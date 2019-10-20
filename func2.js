	/*
	 Verifica se é celular ou Computador
	 */
	function detectar_mobile() 
	{ 
	 if( navigator.userAgent.match(/Android/i)
		 || navigator.userAgent.match(/webOS/i)
		 || navigator.userAgent.match(/iPhone/i)
		 || navigator.userAgent.match(/iPad/i)
		 || navigator.userAgent.match(/iPod/i)
		 || navigator.userAgent.match(/BlackBerry/i)
		 || navigator.userAgent.match(/Windows Phone/i)
		 ){
				return true;
			}
			else {
				return false;
			}
	}

	/*
	 Limpa os arquivos selecionados
	 */
	function limpar()
	{
		var input = $("#imagem");
		input.replaceWith(input.val('').clone(true));
		console.log("limpar!");
	}

	/*
	 Redimensiona uma imagem e passa para a próxima recursivamente
	 */
	 
	 
	function redimensionar()
	{
			console.log("redimensionar!");
		// Se redimensionado todas as imagens
		if (imagem_atual > imagens.length)
		{
			// Definindo progresso de finalizado
			$('#progresso').html('Imagen(s) enviada(s) com sucesso');
	 
			// Limpando imagens
			limpar();
	 
			// Exibindo campo de imagem
			$('#imagem').show();
	 
			// Finalizando
			return;
		}
	 
		// Se não for um arquivo válido
		if ((typeof imagens[imagem_atual] !== 'object') || (imagens[imagem_atual] == null))
		{
			// Passa para a próxima imagem
			imagem_atual++;
			redimensionar();
			return;
		}
	 
		// Obtendo a orientação da imagem
		
		EXIF.getData(imagens[imagem_atual], function(){
			var allMetaData = EXIF.getAllTags(this);
			orient = EXIF.getTag(this, "Orientation");
			console.log(orient);
//			console.log(imagens[imagem_atual]);
		});
		
		// Redimensionando
		resize.photo(imagens[imagem_atual], 700, 'dataURL', function (imagem) {
		//	console.log(imagem);
			console.log(orient);
			$("#prev").html("<img src='"+imagem+"' />");
			var stats = $("#coment").attr("status");
			var os = $("#coment").attr("os");
			var tec = $("#coment").attr("tec");
			var dados = {
				imagem: imagem,
				metodo: "foto",
				os: os,
				tec: tec
			}
//			console.log(dados);
			// Salvando imagem no servidor
			$.post('fotos2.php', dados, function(retorno) {
	 
				// Definindo porcentagem
				var porcentagem = (imagem_atual + 1) / imagens.length * 100;
	 
				// Atualizando barra de progresso
				$('#progresso').text(Math.round(porcentagem) + '%').attr('aria-valuenow', porcentagem).css('width', porcentagem + '%');
	 
				// Aplica delay de 1 segundo
				// Apenas para evitar sobrecarga de requisições
				// e ficar visualmente melhor o progresso
				setTimeout(function () {
					// Passa para a próxima imagem
					imagem_atual++;
					redimensionar();
				}, 1000);
//			console.log(retorno);
			});
	 
		});
	}
	
		/*
	 Envia os arquivos selecionados
	 */
	function enviar() 
	{	
	console.log("enviar!");
		// Verificando se o navegador tem suporte aos recursos para redimensionamento
		if (!window.File || !window.FileReader || !window.FileList || !window.Blob) {
			alert('O navegador não suporta os recursos utilizados pelo aplicativo');
			return;
		}
	 
		// Alocando imagens selecionadas
		imagens = $('#imagem')[0].files;
	 
		// Se selecionado pelo menos uma imagem
		if (imagens.length > 0) 
		{
			// Definindo progresso de carregamento
			$('#progresso').attr('aria-valuenow', 0).css('width', '0%');
	 
			// Escondendo campo de imagem
			$('#imagem').hide();
	 
			// Iniciando redimensionamento
			imagem_atual = 0;
			redimensionar();
		}
	}
	
	