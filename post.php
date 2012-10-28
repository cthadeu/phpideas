<?php 
include "record.php";

class Post extends Record
{
	protected function table() {
		return "post";
	}
}
?>