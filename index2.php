<meta charset="UTF-8">
<link rel="shortcut icon" href="favicon.ico" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
 <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<?php

include "database.php";
session_start();

if(isset($_POST[logout])){
	session_unset();
	session_destroy();
	header("location: index.php");
}

if(!isset($_SESSION[tec])){
	include "login.php";
	echo "&#160;";
	exit;
}
if(isset($_SESSION[vipw])){
	include "senha.php";
	echo "&#160;";
	exit;
}

$os = $_SESSION[os];
$tec = $_SESSION[tec];
$func = $_SESSION[func];
$tecnico = mb_convert_case($_SESSION[nome], MB_CASE_TITLE, "ISO-8859-1");
$adm = $_SESSION[grupo] <= 2 ? true : false;
$dados = dbOs($os);
$dados = $dados[0];
$agenda = explode(" ",$dados[Agenda]);

if($tec == 6){
//	header("location: index2.php");
}


if(isset($_SESSION[rosto]) and $_SESSION[rosto] != ""){
	$rosto = "<a class='left'><img height='100%' src='$_SESSION[rosto]' alt='' class='circle'></a>";
}else{
	$rosto = "<i class='left large material-icons'>face</i>";
}

echo '<div id="principio" class="container">

	<div class="row">
		<div class="col s12">
			<div class="card blue lighten-5">
				<div class="card-content ">';
echo "<nav class='grey darken-3'>
		<div class='nav-wrapper'>
		  $rosto <span class='brand-logo'  > $tecnico</span>
		  <ul id='nav-mobile' class='right '>
		  
			<li><a id='mudasenha'><i class='left material-icons'>vpn_key</i></a></li>
			<li><a id='changeOs'><i class=' left material-icons'>assignment</i>O.S.</a></li>
			<li><a id='logout'><i class='left material-icons large'>exit_to_app</i></a></li>
		  </ul>
		</div>
	</nav>";
	
if(!isset($_SESSION[os])){
	include "os.php";
	echo "&#160;";
}else{
  
if($_SESSION[LISTA]){ // Verifica qual o indice da OS Atual, utilizado para percorrer as OS quando exibindo a OS Atual
	$index = array_search($_SESSION[os], $_SESSION[LISTA], true );
	$total = sizeof($_SESSION[LISTA]);
	if($index > 0){
		$bk = $_SESSION[LISTA][$index - 1];
	}
	if($index < $total){
		$nx = $_SESSION[LISTA][$index + 1];
	}
}
  
  
  
switch ($dados[status]){
	case "EN":
		echo "<br/><span class='titulo card-title'><a class='right btn-flat'><img width='60px'  class='' src='suto.webp'></a><strong>OS</strong> $dados[OS] de <strong>$dados[Cliente]</strong> - ENCAMINHADA </span>";
		break;
	case "A":
		echo "<br/><span class='titulo card-title'><strong>OS</strong> $dados[OS] de <strong>$dados[Cliente]</strong> - ABERTA </span>";
		break;
	case "F":
		echo "<br/><span class='titulo card-title'><a class='right btn-flat'><img width='60px'  class='' src='suto.webp'></a><strong>OS</strong> $dados[OS] de <strong>$dados[Cliente]</strong> - FECHADA </span>";
		break;
	case "AN":
		echo "<br/><span class='titulo card-title'><strong>OS</strong> $dados[OS] de <strong>$dados[Cliente]</strong> - ANÁSLISE </span>";
		break;
	case "AS":
		echo "<br/><span class='titulo card-title'><strong>OS</strong> $dados[OS] de <strong>$dados[Cliente]</strong> - ASSUMIDA </span>";
		break;
	case "AG":
		echo "<br/><span class='titulo card-title'><strong>OS</strong> $dados[OS] de <strong>$dados[Cliente]</strong> - AGENDADA </span>";
		break;
	case "EX":
		echo "<br/><span class='titulo card-title'><strong>OS</strong> $dados[OS] de <strong>$dados[Cliente]</strong> - EXECUÇÃO </span>";
		break;
	default:
		break;
}

echo "<blockquote>";

if($adm){
	$newtec = funcionarios();
	$troca = ""; //reseta a variavel
	foreach($newtec as $linha){
		$troca .= "\n\t<div class='linkar chip brown lighten-4' os='$dados[OS]' func='$linha[tec]'><img src='$linha[img]'>".mb_convert_case($linha[Tecnico], MB_CASE_TITLE, "ISO-8859-1")."</div>\n";
	}
	$classe=' modal-trigger ';
}
$rue = "\t		<div class='modal' id='troca$dados[OS]'>
						<div class='modal-content'>
							<h4>Alterar Funcionario</h4>
							<p>Clique no novo Funcionario</p>
							$troca
						</div>
					</div>";

if($dados[Tecnico] != ""){
	echo "<div href='#troca$dados[OS]' class='$classe chip teal lighten-3'><img src='$dados[img]'>".$dados[Tecnico]." </div> ";
	echo "<div class='chip grey'>".++$index." de $total </div></br> ";
	echo $rue;
}
echo "<div class='chip brown lighten-3'>".$dados[Assunto]." </div> ";
echo "<a href='http://ixc.acessodf.net/aplicativo/radusuarios/rel_22021.php?id=$dados[id_login]'><div class='chip deep-green darken-3'>".$dados[login]." </div></br> </a>";
if($adm){ //Botão para diminuir os dias
	echo "<div class='dia chip light-blue lighten-3' os='$dados[OS]' data='".date('y/m/d', strtotime('-1 days', strtotime($agenda[0])))." $agenda[1]:00'> -1 </div> ";
}
echo "<div class='chip light-blue lighten-3'>".date('d/m/y', strtotime($agenda[0]))." </div> ";
if($adm){ //Botão para aumentar os dias
	echo "<div class='dia chip light-blue lighten-3' os='$dados[OS]' data='".date('y/m/d', strtotime('+1 days', strtotime($agenda[0])))." $agenda[1]:00'> +1 </div> ";
}
echo "<div class='chip deep-orange lighten-3'>".$agenda[1]." </div> ";

//var_dump($dados);
echo " </br> ";
//echo ;
//echo $dados[endereco];

//echo $dados[Abertura];
echo "</blockquote>";

//mensagens(dbOs($os));

mensagens(dbMsg($os));

echo "<a id='modalup' class=\"right waves-effect waves-light btn-large modal-trigger\" href=\"#fechar\"><i class='left  material-icons'>edit</i>Comentar Ordem de Serviço</a>&#160;";

echo "<a id='2changeOs' class=' teal lighten-2 waves-effect waves-light btn'><i class='left  material-icons'>assignment</i>Lista de O.S</a>&#160;";

if($bk){
	echo "<a href='os.php?os=$bk' class=' deep-orange lighten-1 waves-effect waves-light btn'><i class='left  material-icons'>call_received</i>Anterior</a>&#160;";
}

if($nx){
	echo "<a href='os.php?os=$nx' class=' brown lighten-1 waves-effect waves-light btn'><i class='right  material-icons'>call_made</i>Proxima</a>";
}
}
?>
&#160;
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal Structure -->
  <div id="fechar" class="modal">
    <div class="modal-content">
      <h3>Comentar Ordem de Serviço <?=$dados[OS]?></h3>
	  <p>Clique em apenas comentar para postar uma mensagem e <strong>continuar com a posse da OS</strong>, ou clique em Comentar e encaminhar para postar a mensagem e <strong>encaminhar a OS para o financeiro</strong>.</p>
	  <form class="col s12" id="form0s">
		<div class="input-field col s12">
          <textarea rows='6' func="<?=$func?>" adm="<?=$adm?>" status="<?=$dados[status]?>" os="<?=$dados[OS]?>" tec="<?=$tec?>" id="coment" type="textarea" class=" comentar" 
		  placeholder='Descreva detalhes do atendimento!
Não deixe de informar: Sinal da antena/onu;
Foi testado alterar canal e portência do roteador?'></textarea>
          <label class="active" for="coment">Comentário sobre o serviço:</label>
        </div>
		<div id="prev"></div>
		<div class="progress s8">
            <div id="progresso" class="determinate" ></div>
        </div>
		<div id="fotografias" class = "row">
               <label>É possivel postar imagens como um comentário da OS</label>
               <div class = "file-field input-field">
                  <div class = "btn">
                     <i class="material-icons large left">collections</i> Foto
					 <input id="imagem" type="file" accept="image/*" multiple/>
                  </div>
                  
                  <div class = "file-path-wrapper">
                     <input class = "file-path validate" type = "text"
                        placeholder = "Pode enviar mais de uma por vez" />
                  </div>
               </div>    
            </div>
		
	  </form>

    </div>
    <div class="modal-footer">
      <a id="comentar"  class=" orange darken-3 modal-close waves-effect waves-orange btn-large"><i class="material-icons large left">description</i>Somente Comentar</a>
	  
<?php
	if($adm){
		echo '  <a id="adm_fechar"  class=" red darken-3 modal-close waves-effect waves-orange btn-large"><i class="material-icons large left">done_all</i>Fechar OS</a>';
	}else{
	echo '  <a id="encaminhar"  class=" red darken-3 modal-close waves-effect waves-orange btn-large"><i class="material-icons large left">forward</i>Comentar e Encaminhar</a>';
	}
	  
?>
    </div>
  </div>

 <script src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  
 <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/exif-js"></script><!-- https://github.com/exif-js/exif-js -->
 <script src="canvas-to-blob.min.js"></script>
 <script src="resize.js"></script>
 <script src="func2.js"></script>
 <script src="custom.js"></script>
