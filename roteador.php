<?php
class Roteador 
{	
	public static function interpretaURL($pattern, $url) 
	{
		$regex = static::converteVariaveisEmExpressoes($pattern);	
		$regex = static::construirPattern($regex);
		$res = preg_match($regex, $url, $matches);
		return $matches;
	}

	public static function converteVariaveisEmExpressoes($pattern) 
	{
		$res = preg_replace("/\{[a-z]+\}/", "([a-z0-9]+)$", $pattern);
		return $res;
		
	}

	public static function construirPattern($regex)
	{
		$pattern = str_replace("/", "\/", $regex);
		return "/" . $pattern . "/";
	}

	public static function existeRotaParaURL($rota) 
	{
		$matches = static::interpretaURL($rota, $_SERVER['REQUEST_URI']);			
		return (count($matches) > 0);
	}

	public static function construirParametros($pattern, $url) {	
		preg_match("/\{[a-z]+\}/", $pattern, $patternMatches);
		$matches = static::interpretaURL($pattern, $_SERVER['REQUEST_URI']);
		
		if (count($matches) > 1) {
			array_shift($matches);
		}

		array_walk($patternMatches, function(&$item, $key) {
			$item = str_replace("{", "", $item);
			$item = str_replace("}", "", $item);
		});

		$parametros = array_combine($patternMatches, $matches);	
		return $parametros;
	}

	public static function rotear($rotas) {
		array_walk($rotas, function($action, $url) {
			if (Roteador::existeRotaParaURL($url)) {
				$parametros = Roteador::construirParametros($url, $_SERVER['REQUEST_URI']); 		
				$action($parametros);
			} 
		});
	}

}



?>