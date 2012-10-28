<?php
// include "roteador.php";

// $rotas = array(
// 	"/app/{hello}" 	=> function($params) {
// 		echo "Hello World";
// 	},	
// 	"/app/dizerola/{nome}" => function($params) {
// 		extract($params);
// 		echo "Ola " . $nome;
// 	}
// );

// Roteador::rotear($rotas);
include "post.php";
$post = new Post();
$post->todos()->paraCada(function($linha){
	var_dump($linha);
});
?>