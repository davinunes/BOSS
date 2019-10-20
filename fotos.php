<?php
include "database.php";
session_start();
// Recuperando imagem em base64
// Exemplo: data:image/png;base64,AAAFBfj42Pj4
$imagem = $_POST['imagem'];
var_dump($imagem);
// Separando tipo dos dados da imagem
// $tipo: data:image/png
// $dados: base64,AAAFBfj42Pj4
list($tipo, $dados) = explode(';', $imagem);
// Isolando apenas o tipo da imagem
// $tipo: image/png
list(, $tipo) = explode(':', $tipo);
// Isolando apenas os dados da imagem
// $dados: AAAFBfj42Pj4
list(, $dados) = explode(',', $dados);
// Convertendo base64 para imagem
$dados = base64_decode($dados);
// Gerando nome aleatório para a imagem
$nome = "OS_$_SESSION[os]_OP_$_SESSION[tec]_".md5(uniqid(time()));
// Salvando imagem em disco
file_put_contents("./arquivos/boss/{$nome}.jpg", $dados);


if($_POST[metodo] == "foto"){

	$msg = "<img class=\'responsive-img zap\' src=\'arquivos/boss/$nome.jpg\' alt=\'arquivo enviado pelo tecnico\'>";
	
	if($_POST[tec]){
	$tec = filter_input(INPUT_POST, 'tec', FILTER_SANITIZE_STRING);
	}
	if($_POST[os]){
	$os = filter_input(INPUT_POST, 'os', FILTER_SANITIZE_STRING);
	}

		
	if($tec and $os){
	fecharOs($os, $tec, $msg);
	postarFoto($os, "arquivos/boss/$nome.jpg", "$nome.jpg");
	}
}
/**/
?>