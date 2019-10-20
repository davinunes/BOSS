<?php
function keyType($key, $val){ // formata os dados recebidos e retorna uma nova string para o titulo e outra para os dados, dependendo do valor
	$key = explode("_",$key,2);
	$data[key] = mb_convert_case(str_replace('_', ' ', $key[1]), MB_CASE_TITLE, "UTF-8");
//	var_dump($key[0]);
	
	switch($key[0]){
		case "DATA": //formato adequado de data
			$data[val] = $val != "" ? date("d/m/Y", strtotime($val)) : "";
			break;
		case "NUMERO": // remover as casas decimais se for zero
			$data[val] = str_replace('.', ',', $val);
			$data[val] = str_replace(',00', '', $data[val]);
			break;
		case "VALOR": // garantir duas casas decimais
			$data[val] = number_format($val, 2, ',', '');
			break;
		case "DIV": // garantir duas casas decimais
			$data[div] = true;
			$data[val] = mb_convert_case($val, MB_CASE_TITLE, "UTF-8");
			break;
		default: // string
			$data[val] = mb_convert_case($val, MB_CASE_TITLE, "UTF-8");
			break;
	}
	return $data;
}

function bird($sql){ // executa uma querye no firebird
	global $pre;
	$pre	.= "<pre>".$sql."</pre> \n\n";
	## /opt/firebird/bin/isql -user SYSDBA -password masterkey /opt/firebird/BDSIMATEXOM.fdb
	$conexao = ibase_connect("10.133.44.50:/opt/firebird/BDSIMATEXOM.fdb","SYSDBA","masterkey","UTF-8");
	$resultado = ibase_query($conexao, $sql);
	while ($row = ibase_fetch_object($resultado)) {
	   $dados[] = $row;
	}
	ibase_free_result($resultado);
	ibase_close($conexao);
	return $dados;
}

function tabela($sql){ // itera as linhas da tabela
	$linhas=0;
	$divAnterior = "vazio";
	$class="";
	foreach($sql as $k => $a){
		$linhas++;
		$h="<thead>\n"; // Iniciar o cabeçalho do código
		$h .= "\t<tr>";
//		var_dump($a);
		
		$r2="";
		foreach($a as $key => $val){			
			$b = keyType($key, $val); 		// executa a função que formata os dados
			if($b[div]){					// verifico se preciso marcar as seções da tabela
				if($b[val] != $divAnterior and $divAnterior != "vazio"){
					$divAnterior = $b[val];
					$class=" style='border-top: 1px dashed #800!important; '";
				}elseif($divAnterior == "vazio"){
					
					$divAnterior = $b[val];
				}else{
					$class="";
				}
			}		
			$h .= "<th class='del'>$b[key]</th>\n";		// itera o cabeçãlho
			$r2 .= "\t\t<td class=''>$b[val]</td>\n";		// itera as linhas
			
		}
		$r.="\t<tr $class>\n"; 		// Gerar as linhas da tabela
		$r.=$r2;
		$r.="</tr>\n"; //Fecha as linhas da tabela
		$h .= "</tr>";
		$h.="</thead>\n"; // Fecha o Cabeçalho
	}
	global $pre; //importa a consulta
	global $titulo;
	echo "<div class='spoiler'>
		<button class=\"btn\" data-clipboard-target=\"#sql\"><i class=\"material-icons\">content_copy</i> Copiar para área de transferência</button>
		<input type='checkbox' id='spoilerid_1'>
		<label for='spoilerid_1'>Mostrar Consulta</label>
		<div class='spoiler_body'>$pre</div>
		<label class='tt'>$linhas</label>
		<label class='tt'>$titulo</label>
		</div>";

	echo "<table id='sql' class='alter'>";
	echo $h;
	echo $r;
	echo "</table>";
	echo "<br>";
}
?>