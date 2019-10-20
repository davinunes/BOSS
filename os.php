<style>

html,body {
  font-family: 'Open Sans', serif;
  font-size: 20px;
  font-weight: 300;
}
.hero.is-success {
  background: #f2f7fa;
}
.hero .nav, .hero.is-success .nav {
  -webkit-box-shadow: none;
  box-shadow: none;
}
input {
  font-weight: 300;
}
p {
  font-weight: 700;
}
</style>
<?php
session_start();

if($_GET[os]){
	$_SESSION[os] = $_GET[os];
	header("location: index.php");
}
if($_POST[os]){
	$_SESSION[os] = $_POST[os];
	header("location: index.php");
}

if($_POST[troca]){
	unset($_SESSION[os]);
//	header("location: index.php");
	exit;
}

	if($_GET[dia]){
		$data = date('Y-m-d',strtotime($_GET[dia]));
		$_SESSION[dia] = $_GET[dia];
	}elseif($_SESSION[dia]){
		$data = $_SESSION[dia];
	}else{
		$data = date('Y-m-d');
	}


?>



	<div class="row">
 	 <form method="post">
        <div class="section"></div>
  
            <div class='row'>
			
				<div class='input-field col s2'>
					<a href="?dia=<?=date('Y-m-d', strtotime('-1 days', strtotime($data)))?>" class="btn-large white black-text  waves-effect z-depth-1 y-depth-1"><i class="material-icons left">chevron_left</i></a>
				</div>
				
				<div class='input-field col s2'>
					<a href="?dia=<?=date('Y-m-d', strtotime('+1 days', strtotime($data)))?>" class="btn-large white black-text  waves-effect z-depth-1 y-depth-1"><i class="material-icons left">chevron_right</i></a>
				</div>
			  
              <div class='input-field col s4'>
                <input class='validate' type="number" name='os' autofocus required placeholder='Digite um numero de OS'/>
                <label for='email'>Ordem de Serviço</label>
              </div>
			  
			  <div class='input-field col s4'>
                <button   type='submit' name='btn_os' class='btn-large white black-text  waves-effect z-depth-1 y-depth-1'><i class="material-icons left">format_list_bulleted</i>Selecionar</button>
              </div>
            </div>

              
<!-- Estilo do Botão
style="left: 50%; margin-right: -50%; transform: translate(-50%, -50%);"
-->
   
		</form>

	</div>

	<div id="lista_os" class="row">

<?php

	$quando = $data == date('Y-m-d') ? "HOJE" : date('d/m',strtotime($data));

	echo "<center><h4>O.S. PENDENTES DE $quando</h4></center>";

	hoje($data);

?>

	</div>

<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  
 <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
 
  <script src="func.js"></script>
 
 <script src="custom.js"></script>