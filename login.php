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
if($_POST[username] and $_POST[password]){
	$sql = "select nome, id, imagem, id_grupo from usuarios where email = '{$_POST[username]}' and senha = sha2('{$_POST[password]}', '256') and status = 'A' ";
	$lg = DBExecute($sql);
	if(mysqli_num_rows($lg) == 1){
		$retorno = mysqli_fetch_assoc($lg);
		$_SESSION[tec] = $retorno[id];
		$_SESSION[nome] = $retorno[nome];
		$_SESSION[rosto] = $retorno[imagem];
		$_SESSION[grupo] = $retorno[id_grupo];
	}
	
	header("location: index.php");
}

?>


<div class="container">
	<div class="row">
	<div class="section"></div>
   <main>
    <center>
     <div class="container">
	 
        <div  class="z-depth-3 y-depth-3 x-depth-3 grey lighten-4 orange-text text-darken-3 row" style="display: inline-block; padding: 32px 48px 0px 48px; border: 1px; margin-top: 100px; solid #EEE;">
        <div class="section"><h5><strong>BAIXA DE ORDEM DE SERVIÇO SIMPLIFICADA</strong></h5></div>
		<div class="section"></div>
		<div class="section"><i class="mdi-alert-error red-text"></i></div>
      
<form method="post">
	<div class='row'>
	  <div class='input-field col s12'>
		<input class='validate' type="text" name='username' id='email' required placeholder=''/>
		<label for='email'>Usuario</label>
	  </div>
	</div>
	<div class='row'>
	  <div class='input-field col m12'>
		<input class='validate' type='password' name='password' id='password' required placeholder=''/>
		<label for='password'>Senha</label>
	  </div>
	  <label style='float: right;'>
	  <a><b style="color: #F5F5F5;">Sem Essa!</b></a>
	  </label>
	</div>
	<br/>
	<center>
	  <div class='row'>
		<button style="left: 50%; margin-right: -50%; transform: translate(-50%, -50%);"  type='submit' name='btn_login' class='col  s6 btn btn-large white black-text  waves-effect z-depth-1 y-depth-1'>Login</button>
	  </div>
	</center>
</form>
        </div>

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
 
  <script src="func.js"></script>
 
 <script src="custom.js"></script>