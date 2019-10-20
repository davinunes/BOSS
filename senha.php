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

include_once "database.php";
session_start();
// var_dump($_SESSION);

if($_POST[desiste]){
	unset($_SESSION[vipw]);
	header("location: index.php");
}

if($_POST[vipw]){
	$_SESSION[vipw] = $_POST[vipw];
	header("location: index.php");
}

if($_POST[novasenha]){
	
	$sql = "update usuarios set senha = sha2('{$_POST[novasenha]}', '256') where id = '{$_SESSION[tec]}' and senha = sha2('{$_POST[senha]}', '256')";
	echo "<br/>".$sql;
	$lg = DBExecute($sql);
	unset($_POST[novasenha]);
	unset($_POST[senha]);
	session_destroy();
//	header("location: index.php");
	exit;
}


?>


<div class="container">
	<div class="row">

   <main>
    <center>
     <div class="container">
	 <form method="post">
        <div  class="z-depth-3 y-depth-3 x-depth-3 grey green-text lighten-4 row" style="display: inline-block; padding: 32px 48px 0px 48px; border: 1px; margin-top: 100px; solid #EEE;">
        <div class="section">ALTERAR SENHA DE <?=$_SESSION[nome]?></div>
<div class="section"></div>
    
      <div class="section"><i class="mdi-alert-error red-text"></i></div>
      
  
            <div class='row'>
              <div class='input-field col s12'>
                <input class='validate' type="password" id="senha" name='senha' required placeholder=''/>
                <label for='senha'>Senha Atual</label>
              </div>
            </div>
			
			<div class='row'>
              <div class='input-field col s12'>
                <input class='validate' type="password" id="novasenha" name='novasenha' required placeholder=''/>
                <label for='senha'>Nova Senha</label>
              </div>
            </div>
			
			<div class='row'>
              <div class='input-field col s12'>
                <input class='validate' type="password" id="confirmar" name='confirmar' required placeholder=''/>
                <label for='senha'>Confirmar nova senha</label>
              </div>
            </div>
            <br/>
            <center>
              <div class='row'>
                <a id="alteraSenha" style="left: 50%; margin-right: -50%; transform: translate(-50%, -50%);"  type='submit' name='alteraSenha' class='col  s6 btn btn-large red black-text  waves-effect z-depth-1 y-depth-1'>Alterar Senha</a>
              </div>
			  <div class='row'>
                <a id="desiste" style="left: 50%; margin-right: -50%; transform: translate(-50%, -50%);"  type='submit' name='alteraSenha' class='col  s6 btn btn-large white black-text  waves-effect z-depth-1 y-depth-1'>Cancelar</a>
              </div>
            </center>
     
        </div>
		</form>
       </div>
      </center>
      </main>
    

	</div>
</div>



 <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  
 <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

 <script src="canvas-to-blob.min.js"></script>
 <script src="resize.js"></script>
 <script src="func.js"></script>
 <script src="custom.js"></script>