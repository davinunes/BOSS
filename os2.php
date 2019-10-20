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
if($_POST[os]){
	$_SESSION[os] = $_POST[os];
	header("location: index.php");
}
if($_POST[troca]){
	unset($_SESSION[os]);
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
        <div  class="z-depth-3 y-depth-3 x-depth-3 grey deep-orange-text lighten-4 row" style="display: inline-block; padding: 32px 48px 0px 48px; border: 1px; margin-top: 100px; solid #EEE;">
        <div class="section">AGORA DIGITE O NUMERO DA ORDEM DE SERVIÇO</div>
    
      <div class="section"><i class="mdi-alert-error red-text"></i></div>
      
  
            <div class='row'>
              <div class='input-field col s12'>
                <input class='validate' type="text" name='os' required placeholder=''/>
                <label for='email'>Numero da OS</label>
              </div>
            </div>
            <br/>
            <center>
              <div class='row'>
                <button style="left: 50%; margin-right: -50%; transform: translate(-50%, -50%);"  type='submit' name='btn_login' class='col  s6 btn btn-large white black-text  waves-effect z-depth-1 y-depth-1'>Acessar O.S.</button>
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
 
  <script src="func.js"></script>
 
 <script src="custom.js"></script>