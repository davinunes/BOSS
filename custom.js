 // Iniciando biblioteca
var resize = new window.resize();
resize.init();
 
// Declarando variáveis
var imagens;
var imagem_atual;
var imagens_postadas;
 
 $(document).ready(function(){
	 
	 var permiteImagem = $("#coment").attr("status");
	 var adm = $("#coment").attr("adm");
	 if(permiteImagem == "EN" || permiteImagem == "F"){
		$('#modalup').hide();
	}
	if(adm == "1" ){
		$('#modalup').show();
			if(permiteImagem == "F"){
				$('#modalup').hide();
			}
	}
	 
	 var cell = detectar_mobile();
	 if(cell){ //Verifica se é celular
		 console.log("Isto é um celular");
//		 alert("Celular!");
			$("#principio").removeClass("container");
			
			$("p").css({
				"font-size"		: 	"2.5em",
				"line-height"	:	"110%",
				"text-align"	:	"justify"
				
			});
			
			$("nav>li>a").css({
				"font-size"		: 	"3em"
				
			});
			
			$(".modal").css({
				"width"		: 	"80%",
				"min-height"	:	"60%"
				
			});
			
			$("input").css({
				"font-size"		: 	"2.5em",
				"line-height"	:	"110%",
				"text-align"	:	"justify"
				
			});
			$(".comentar").css({
				"height"		: 	"55%",
				"font-size"		: 	"2.5em",
				"line-height"	:	"110%",
				"text-align"	:	"justify"
				
			});
			$(".titulo").css({
				"font-size"		: 	"2.5em",
				"line-height"	:	"110%",
				"text-align"	:	"justify"
				
			});
	 }else{
		 console.log("Nao é um celular");
			$("p").css({
				"font-size"		: 	"20px",
				"line-height"	:	"110%",
				"text-align"	:	"justify"
			
			});
			$(".comentar").css({
				"height"		: 	"90px",
				"line-height"	:	"110%",
				"text-align"	:	"justify"
					
			});
			
			$(".modal").css({
				"width"		: 	"80%",
				"min-height"	:	"80%"
				
			});
	 }
	 
    $('.modal').modal();
	
	// Quando selecionado as imagens
    $('#imagem').on('change', function () {
        enviar();
    });
	
	$(".zap").click(function(){
		console.log("rodar");
		$(this).rotate('90'); // By calculating the height and width of the image in the load function // $(img).css('transform-origin', (imgWidth / 2) + ' ' + (imgHeight / 2) );
	});
	
	
	$(".linkar").click(function(){
		var dados = {
			metodo:"mudaTec",
			os : $(this).attr("os"),
			func: $(this).attr("func")
		}
		$.post( "database.php", dados, function( retorna ) {
			console.log(retorna);
			if (retorna === "ok"){
				M.toast({html: 'SUCESSO!!!', classes: 'rounded'});
				$("#btn-clear").click();
				window.location.reload(true);
			}
	
		});
		
	});
	
	$("#reagendar").click(function(){
		console.log("reagendar");
		var dados = {
			metodo:"reabrir",
			os : $(this).attr("os")
		}
		$.post( "database.php", dados, function( retorna ) {
			if (retorna === "ok"){
				M.toast({html: 'SUCESSO!!!', classes: 'rounded'});
				$("#btn-clear").click();
				window.location.reload(true);
			}
	
		});
		
	});
	
	$(".brand-logo").click(function(){
		$(".colapso").toggle();
		
	});
	
	
	$(".dia").click(function(){
		var dados = {
			metodo:"agenda",
			os : $(this).attr("os"),
			data: $(this).attr("data")
		}
		$.post( "database.php", dados, function( retorna ) {
			console.log(retorna);
			if (retorna === "ok"){
				M.toast({html: 'SUCESSO!!!', classes: 'rounded'});
				$("#btn-clear").click();
				window.location.reload(true);
			}
	
		});
		
	});
	
	
	$("#comentar").click(function(){
		console.log("Clicou");
		
		var stats = $("#coment").attr("status");
		var msg = $("#coment").val();
		var os = $("#coment").attr("os");
		var tec = $("#coment").attr("tec");
		var func = $("#coment").attr("func");
		var dados = {
			metodo:"close",
			msg : msg,
			os: os,
			tec: tec
			
		}
		if(stats != "F"){
			if(stats != "EN" ||  adm == "1" ){
				$.post( "database.php", dados, function( retorna ) {
				console.log(retorna);
				if (retorna === "ok"){
					M.toast({html: 'SUCESSO!!!', classes: 'rounded'});
					$("#btn-clear").click();
					window.location.reload(true);
				}
			
				});
			}
		}else{
			alert("OS ja foi encaminhada ou fechada!");
		}
		console.log(dados);

	});
	
	$("#encaminhar").click(function(){
	var encaminhar = confirm('Depos que encaminhar, nao podera mais postar mensagem! Continuar?');
	if (encaminhar){
		
		console.log("Clicou em encaminhar");
		
		var stats = $("#coment").attr("status");
		var msg = $("#coment").val();
		var tec = $("#coment").attr("tec");
		var func = $("#coment").attr("func");
		if(msg == ""){
			alert("Precisa escrever uma mensagem!");
			return;
		}
		var os = $("#coment").attr("os");
		var tec = $("#coment").attr("tec");
		var dados = {
			metodo:"close",
			msg : msg,
			os: os,
			tec: tec,
			func: func,
			enc: "sim"
			
		}
		if(stats != "EN" && stats != "F"){
			$.post( "database.php", dados, function( retorna ) {
			console.log(retorna);
			if (retorna === "ok"){
				M.toast({html: 'SUCESSO!!!', classes: 'rounded'});
				$("#btn-clear").click();
				window.location.reload(true);
			}
			
		});
		}else{
			alert("OS ja foi Encaminhada ou Fechada!");
		}
		console.log(dados);
	}

	});
	
	$("#adm_fechar").click(function(){
	var encaminhar = confirm('Depos que Fechar, não mais poderá comentar por esta plataforma! Continuar?');
	if (encaminhar){
		
		console.log("Clicou em adm-fechar");
		
		var stats = $("#coment").attr("status");
		var msg = $("#coment").val();
		var tec = $("#coment").attr("tec");
		var func = $("#coment").attr("func");
		if(msg == ""){

			msg = "Realizando fechamento da OS!";
			
		}
		var os = $("#coment").attr("os");
		var tec = $("#coment").attr("tec");
		var dados = {
			metodo:"close",
			msg : msg,
			os: os,
			func:func,
			tec: tec,
			enc: "fechar"
			
		}
		if(stats != "F"){
			$.post( "database.php", dados, function( retorna ) {
			console.log(retorna);
			if (retorna === "ok"){
				M.toast({html: 'SUCESSO!!!', classes: 'rounded'});
				$("#btn-clear").click();
				window.location.reload(true);
			}
			
		});
		}else{
			alert("OS ja foi Fechada!");
		}
		console.log(dados);
	}

	});
	
	$("#changeOs").click(function(){
		$.post( "os.php", {troca:"1"}, function( retorna ) {
			console.log("MudarOS");
			window.location.reload(true);
		});
	});
	
	$("#2changeOs").click(function(){
		$.post( "os.php", {troca:"1"}, function( retorna ) {
			console.log("MudarOS");
			window.location.reload(true);
		});
	});
	
	$("#mudasenha").click(function(){
		$.post( "senha.php", {vipw:"1"}, function( retorna ) {
			console.log("MudarSenha");
			window.location.reload(true);
		});
	});
	
	$("#desiste").click(function(){
		$.post( "senha.php", {desiste:"1"}, function( retorna ) {
			console.log("MudarSenha");
			window.location.reload(true);
		});
	});
	
	$("#logout").click(function(){
		$.post( "index.php", {logout:"1"}, function( retorna ) {
			console.log("Sair do Sistema");
			window.location.reload(true);
		});
	});
	
	$("#alteraSenha").click(function(){
		var senha = $("#senha").val();
		var novasenha = $("#novasenha").val();
		var confirmar = $("#confirmar").val();
		
		if(novasenha == confirmar){
			var dados = {
				senha: senha,
				novasenha: novasenha
			}
			$.post( "senha.php", dados, function( retorna ) {
				console.log(retorna);
				window.location.reload(true);
			});
		}else{
			alert("Nova senha difere da confirmacao");
		}
		
	});


  });