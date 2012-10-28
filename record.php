<?php
const USERNAME = "root";
const PASSWORD = "";
const DSN = "mysql:host=localhost;dbname=test_php";

function doLog($msg) {
	var_dump($msg);
}

abstract class Record
{
	protected $connection;	
	protected $currentResultSet;

	private function conectar() {		
		$this->connection = new PDO(DSN, USERNAME, PASSWORD);
		doLog($this->connection);
	}

	public function todos() {
		$this->conectar();		
		$preparedStatement = $this->connection->prepare("select * from " . $this->table());		
		$preparedStatement->execute();
		$this->currentResultSet = $preparedStatement->fetch(PDO::FETCH_ASSOC);		
		doLog("executando query");
		return $this;
	}	

	public function paraCada($callback) {		
		foreach($this->currentResultSet as $row) {
			$callback($row);
		}
	}

	protected abstract function table();

}
?>