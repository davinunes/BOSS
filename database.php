<?php


define('DB_HOSTNAME', 'localhost');
define('DB_DATABASE', 'ixcprovedor');
define('DB_USERNAME', 'boss');
define('DB_PASSWORD', 'ilunne');
define('DB_PREFIX', '');
define('DB_CHARSET', 'LATIN1');

function DBConnect(){ # Abre Conexão com Database
	$link = @mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die(mysqli_connect_error());
	mysqli_set_charset($link, DB_CHARSET) or die(mysqli_error($link));
	return $link;
}

function DBClose($link){ # Fecha Conexão com Database
	@mysqli_close($link) or die(mysqli_error($link));
}

function DBEscape($dados){ # Proteje contra SQL Injection
	$link = DBConnect();
	
	if(!is_array($dados)){
		$dados = mysqli_real_escape_string($link,$dados);
	}else{
		$arr = $dados;
		foreach($arr as $key => $value){
			$key	= mysqli_real_escape_string($link, $key);
			$value	= mysqli_real_escape_string($link, $value);
			
			$dados[$key] = $value;
		}
	}
	DBClose($link);
	return $dados;
}

function DBExecute($query){ # Executa um Comando na Conexão
	$link = DBConnect();
	$result = mysqli_query($link,$query) or die(mysqli_error($link));
	
	DBClose($link);
	return $result;
}



function dbMsg($termo){ # Lê os Veiculos da Tabela
	
	$sql  =" select "; //
	$sql .=" 	DATE_FORMAT(m.data, '%d-%m-%Y %T') as Data, ";
	$sql .=" 	op.nome as Operador, ";
	$sql .=" 	op.imagem as img, ";
	$sql .=" 	m.mensagem as Mensagem ";
	$sql .=" from ";
	$sql .=" 	su_oss_chamado_mensagem m ";
	$sql .=" left join usuarios op on op.id = m.id_operador";
	$sql .=" left join su_oss_evento ev on ev.id = m.id_evento";
	$sql .=" where ";
	$sql .=" 	id_chamado='$termo' ";

	$result	= DBExecute($sql);

	if(!mysqli_num_rows($result)){

	}else{
		while($retorno = mysqli_fetch_assoc($result)){
			$dados[] = $retorno;
		}
		return $dados;
	}
}

function tecnico($termo){ # Lê os Veiculos da Tabela
//	echo $sql;
	
	$sql  ="select ";
	$sql .="	nome, funcionario ";
	$sql .="from ";
	$sql .="	usuarios ";
	$sql .="where ";
	$sql .="	id='$termo' ";

	$result	= DBExecute($sql);

	if(!mysqli_num_rows($result)){

	}else{
		while($retorno = mysqli_fetch_assoc($result)){
			$dados[] = $retorno;
		}
		return $dados;
	}
}

function dbOs($termo){ # Lê os Veiculos da Tabela
//	echo $sql;
	
	$sql  ="select ";
	$sql .="	os.id as OS, ";
	$sql .="	c.razao as Cliente, ";
	$sql .="	ass.assunto as Assunto, ";
	$sql .=" 	op.imagem as img, ";
	$sql .="	os.mensagem as Abertura, ";
	$sql .="	DATE_FORMAT(os.data_agenda,'%d-%m-%Y %H:%i') as Agenda, ";
	$sql .="	tec.funcionario as Tecnico, ";
	$sql .="	os.status, ";
	$sql .="	os.endereco, os.id_login, ";
	$sql .="	rd.login as login "; //os.id_login
	$sql .="from ";
	$sql .="	su_oss_chamado os ";
	$sql .="left join cliente c on os.id_cliente = c.id ";
	$sql .="left join su_oss_assunto ass on ass.id = os.id_assunto ";
	$sql .="left join funcionarios tec on tec.id = os.id_tecnico ";
	$sql .="left join radusuarios rd on rd.id = os.id_login ";
	$sql .="left join usuarios op on op.funcionario = tec.id ";
	$sql .="where ";
	$sql .="	os.id='$termo' ";

	$result	= DBExecute($sql);

	if(!mysqli_num_rows($result)){

	}else{
		while($retorno = mysqli_fetch_assoc($result)){
			$dados[] = $retorno;
		}
		return $dados;
	}
}

function mensagens($sql){ // itera as linhas da tabela
	$linhas=0;
	foreach($sql as $a){
		$linhas++;
		$a[Operador] =  mb_convert_case($a[Operador], MB_CASE_TITLE, "ISO-8859-1");
//		var_dump($a);
		if($a[img] != ""){
			$r.= "\t<li class='collection-item avatar'>
			\n\t<img src='$a[img]' alt='' class='circle right'>
			\n\t<span class='operador blue-text title'><strong>$a[Operador]</strong> em $a[Data]</span>
			\n\t<p>$a[Mensagem] </p>\n";
		}else{
			$r.="\t<li class='collection-item '>\n";
			$r.="<span class='operador blue-text title'><strong>$a[Operador]</strong> em $a[Data]</span>";
			$r.="<p>$a[Mensagem] </p>\n";
		}

	}

	echo '<ul class="collection">';
	echo $r;
	echo "</ul>";
	echo "<br>";
}

function fecharOs($os, $tec, $msg){

	$dt = date('Y-m-d H:m:s');
	$sql  ="insert into su_oss_chamado_mensagem ";
	$sql .=" (mensagem, id_chamado, id_operador, data, id_evento  ) ";
	$sql .=" values ";
	$sql .=" ('$msg', '$os', '$tec', '$dt', '9') ";
	
//	echo $sql;
	if(DBExecute($sql)){
		echo "ok";
	}else{
		echo "erro";
	}

}

function postarFoto($os, $arquivo, $nome){

	$dt = date('Y-m-d H:m:s');
	$sql  ="insert into su_oss_chamado_arquivos ";
	$sql .=" (id_oss_chamado, descricao, local_arquivo, data_envio, classificacao_arquivo, nome_arquivo  ) ";
	$sql .=" values ";
	$sql .=" ('$os', 'Arquivo postado pelo tecnico no BOSS', '$arquivo', '$dt', 'P', '$nome' ) ";
	
//	echo $sql;
	if(DBExecute($sql)){
		echo "ok";
	}else{
		echo "erro";
	}

}

function reagendar($os){

	$sql  ="update  su_oss_chamado ";
	$sql .=" set ";
	$sql .=" status = 'AG' "; //
	$sql .=" where ";
	$sql .=" id = $os ";
	
//	echo $sql;
	if(DBExecute($sql)){
		echo "ok";
	}else{
		echo "erro";
	}

}

function transfer($os, $user){

	$dt = date('Y-m-d H:m:s');
	$sql  ="update  su_oss_chamado ";
	$sql .=" set ";
	$sql .=" status = 'EN', "; //
	$sql .=" setor = '3', ";
	$sql .=" id_tecnico = '$user' ";
	$sql .=" where ";
	$sql .=" id = $os ";
	
//	echo $sql;
	if(DBExecute($sql)){
	//	echo "ok";
	}else{
		echo "erro";
	}

}

function agenda($os, $data){
	//2016-12-28 19:28:34
	
	$dt = date('Y-m-d H:m:s');
	$sql  ="update  su_oss_chamado ";
	$sql .=" set ";
	$sql .=" data_agenda = '$data' ";
	$sql .=" where ";
	$sql .=" id = $os ";
	
	if(DBExecute($sql)){
		echo "ok";
	}else{
		echo "erro";
	}

}

function face($os, $func){

	$dt = date('Y-m-d H:m:s');
	$sql  ="update  su_oss_chamado ";
	$sql .=" set ";
	$sql .=" id_tecnico = '$func' ";
	$sql .=" where ";
	$sql .=" id = $os ";
	
	if(DBExecute($sql)){
		echo "ok";
	}else{
		echo "erro";
	}

}

function comenta($os, $user){

	$dt = date('Y-m-d H:m:s');
	$sql  ="update  su_oss_chamado ";
	$sql .=" set ";
	$sql .=" status = 'EN', "; //
	$sql .=" setor = '3', ";
	$sql .=" id_tecnico = '$user' ";
	$sql .=" where ";
	$sql .=" id = $os ";
	
//	echo $sql;
	if(DBExecute($sql)){
	//	echo "ok";
	}else{
		echo "erro";
	}

}

function charset($string){
	// If it's not already UTF-8, convert to it

    $string = mb_convert_encoding($string, 'latin1', 'utf-8');


return $string;
}

function finaliza($os, $user){

	$dt = date('Y-m-d H:m:s');
	$sql  ="update  su_oss_chamado ";
	$sql .=" set ";
	$sql .=" status = 'F', "; //
	$sql .=" setor = '3', ";
	$sql .=" id_tecnico = '$user' ";
	$sql .=" where ";
	$sql .=" id = $os ";
	
//	echo $sql;
	if(DBExecute($sql)){
	//	echo "ok";
	}else{
		echo "erro";
	}

}

function funcionarios(){
	//Selecionar todos os técnicos
	$sql  =" select ";
	$sql .=" 	op.imagem as img, tec.funcionario as Tecnico, tec.id as tec "; //op.imagem as img
	$sql .=" from ";
	$sql .=" 	funcionarios tec ";
	$sql .=" left join usuarios op on op.funcionario = tec.id ";
	$sql .=" where ";
	$sql .=" 	op.status = 'A' ";


	$comentadas	= DBExecute($sql);
	if(mysqli_num_rows($comentadas)){
		while($retorno = mysqli_fetch_assoc($comentadas)){
			$newtec[] = $retorno;
		}
	}
	
	return $newtec;
}

function hoje($data){
	
	//Marca a data de hoje e de amanhã pra usar na pesquisa das OS
	$data = date('Y-m-d',strtotime($data));
	$data2 = date('Y-m-d', strtotime('+1 days', strtotime($data)));


	$newtec = funcionarios();
	
	// Conta quantas OS estão encaminhadas ou fechadas
	$sql  =" select ";
	$sql .=" 	count(*) as ok"; //op.imagem as img
	$sql .=" from ";
	$sql .=" 	su_oss_chamado os ";
	$sql .=" where ";
//	$sql .=" 	os.data_agenda >= CURDATE( )";
	$sql .=" 	os.data_agenda >= '$data'";
//	$sql .=" 	and os.data_agenda < (CURDATE( ) + 1)";
	$sql .=" 	and os.data_agenda < '$data2' ";
	$sql .=" 	and (os.status = 'EN' or os.status = 'F')";

	$comentadas	= DBExecute($sql);
	if(mysqli_num_rows($comentadas)){
		while($retorno = mysqli_fetch_assoc($comentadas)){
			$mc = $retorno;
		}
	}
	
	$ok = $mc[ok];
	
	
	//Conta quantas OS não agendadas
	$sql  =" select ";
	$sql .=" 	count(*) as ok"; //op.imagem as img
	$sql .=" from ";
	$sql .=" 	su_oss_chamado os ";
	$sql .=" where ";
//	$sql .=" 	os.data_agenda >= CURDATE( )";
	$sql .=" 	os.data_agenda >= '$data'";
//	$sql .=" 	and os.data_agenda < (CURDATE( ) + 1)";
	$sql .=" 	and os.data_agenda < '$data2'";
	$sql .=" 	and (os.status = 'AG' or os.status = 'EX')";

	$comentadas	= DBExecute($sql);
	if(mysqli_num_rows($comentadas)){
		while($retorno = mysqli_fetch_assoc($comentadas)){
			$mc = $retorno;
		}
	}
	$nok = $mc[ok];
	
	//Marca se o usuário será admin do boss
	$adm = $_SESSION[grupo] <= 2 ? true : false;
	
	
	//Pesquisa as OS de Hoje
	$sql  =" select ";
	$sql .=" 	os.id as OS, "; //op.imagem as img
	$sql .=" 	c.razao as Cliente, ";
	$sql .=" 	op.imagem as img, ";
	$sql .=" 	ass.assunto as Assunto, ";
	$sql .=" 	os.mensagem as Abertura, ";
	$sql .=" 	DATE_FORMAT(os.data_agenda,'%d-%m-%Y %H:%ih') as Agenda, ";
	$sql .=" 	tec.funcionario as Tecnico, ";
	$sql .=" 	os.status, ";
	$sql .=" 	TIME_FORMAT(os.data_agenda, '%H:%i') as horario, ";
	$sql .=" 	rd.login as login "; //os.id_login
	$sql .=" from ";
	$sql .=" 	su_oss_chamado os ";
	$sql .=" left join cliente c on os.id_cliente = c.id ";
	$sql .=" left join su_oss_assunto ass on ass.id = os.id_assunto ";
	$sql .=" left join funcionarios tec on tec.id = os.id_tecnico ";
	$sql .=" left join usuarios op on op.funcionario = tec.id ";
	$sql .=" left join radusuarios rd on rd.id = os.id_login ";
	$sql .=" where ";
//	$sql .=" 	os.data_agenda >= CURDATE( )";
	$sql .=" 	os.data_agenda >= '$data'";
//	$sql .=" 	and os.data_agenda < (CURDATE( ) + 1)";
	$sql .=" 	and os.data_agenda < '$data2'";
	if($adm){
	$sql .=" 	and (os.status = 'AG' or os.status = 'EX' or os.status = 'EN' or os.status = 'F')";
	}else{
	$sql .=" 	and (os.status = 'AG' or os.status = 'EX')";
	}
	$sql .=" order by"; 
	$sql .=" 	os.data_agenda";

	$result	= DBExecute($sql);
	
	if(mysqli_num_rows($result)){
		$abertas = mysqli_num_rows($result);
		while($retorno = mysqli_fetch_assoc($result)){
			$dados[] = $retorno;
		}
	}
	
	//Popula a lista de OS de hoje, usada para o botão de proxima e anterior
	unset($_SESSION[LISTA]);
	foreach($dados as $a){
		$_SESSION[LISTA][] = $a[OS];
	}

//	var_dump($_SESSION[LISTA]);
	$linhas = 0;

	// monta a lista
	foreach($dados as $a){
		
		//Lista de tecnicos pra alterar
		if($adm){
			$troca = ""; //reseta a variavel
			foreach($newtec as $linha){
				$troca .= "\n\t<div class='linkar chip brown lighten-4' os='$a[OS]' func='$linha[tec]'><img src='$linha[img]'>".mb_convert_case($linha[Tecnico], MB_CASE_TITLE, "ISO-8859-1")."</div>\n";
			}
			$classe = " modal-trigger ";
		}
		
		
		
		
		//	var_dump($troca);
		$status = $a[status] == "F" ? "done_all" : "done";
		if($a[status] == "F"){
			$colapso = "colapso";
			$color = "purple accent-1";
		}elseif($a[status] == "EN"){
			$colapso = "colapso";
			$color = " blue lighten-2";
		}else{
			$colapso = "";
			$color = "";
		}
	//	var_dump($a);
		
		if($a[img] != ""){
			$r.= "\t	<a href='os.php?os=$a[OS]&index=$linhas' class='$colapso collection-item avatar $color'>
			\n\t		<img  $edit src='$a[img]' alt='' class='$classe circle' href='#troca$a[OS]'>
			\n\t		<span class='operador blue-text title'><strong>$a[Cliente] | $a[horario]</strong> </span>
			\n\t		<p>$a[OS]: $a[Assunto]</p>
			\n\t		
			\n\t		<div class='chip purple darken-4 white-text secondary-content'>$a[login]</div>
						</a>\n";
			
		}else{
			$r.= "\t	<a  href='os.php?os=$a[OS]&index=$linhas'  $edit  class='$colapso collection-item avatar $color'>
			\n\t		<i  $edit class='$classe material-icons circle' href='#troca$a[OS]'>$status</i>
			\n\t		<span class='operador blue-text title'><strong>$a[Cliente] | $a[horario]</strong> </span>
			\n\t		<p>$a[OS]: $a[Assunto]</p> 
			\n\t		<div class='chip purple darken-4 white-text secondary-content'>$a[login]</div>
						</a>\n";
		}
		$r.="\t		<div class='modal' id='troca$a[OS]'>
						<div class='modal-content'>
							<h4>Alterar Funcionario</h4>
							<p>Clique no novo Funcionario</p>
							$troca
						</div>
					</div>";
		$linhas++;
	}
	echo "<span>Comentadas: $ok | Pendentes: $nok</span>";
	echo '<ul class="collection">';
	echo $r;
	echo "</ul>";

}

if($_POST[metodo] == "mudaTec"){


	if($_POST[func]){
	$func = filter_input(INPUT_POST, 'func', FILTER_SANITIZE_STRING);
	}
	if($_POST[os]){
	$os = filter_input(INPUT_POST, 'os', FILTER_SANITIZE_STRING);
	}

	face($os, $func);
}

if($_POST[metodo] == "agenda"){


	if($_POST[data]){
	$data = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_STRING);
	}
	if($_POST[os]){
	$os = filter_input(INPUT_POST, 'os', FILTER_SANITIZE_STRING);
	}

	agenda($os, $data);
}

if($_POST[metodo] == "close"){
	if($_POST[msg]){
	$msg = charset(filter_input(INPUT_POST, 'msg', FILTER_SANITIZE_STRING));
	}
	if($_POST[tec]){
	$tec = filter_input(INPUT_POST, 'tec', FILTER_SANITIZE_STRING);
	}
	if($_POST[func]){
	$func = filter_input(INPUT_POST, 'func', FILTER_SANITIZE_STRING);
	}
	if($_POST[os]){
	$os = filter_input(INPUT_POST, 'os', FILTER_SANITIZE_STRING);
	}
	if($_POST[enc]){
	$enc = filter_input(INPUT_POST, 'enc', FILTER_SANITIZE_STRING);
	}
	
	if($enc == "sim"){
		transfer($os, $func);
	}elseif($enc == "fechar"){
		finaliza($os, $func);
	}
	
	if($msg and $tec and $os){
	fecharOs($os, $tec, $msg);
	}
}

if($_POST[metodo] == "reabrir"){
	
	if($_POST[os]){
	$os = filter_input(INPUT_POST, 'os', FILTER_SANITIZE_STRING);
	}

	reagendar($os);
}

?>