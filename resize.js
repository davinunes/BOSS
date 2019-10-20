window.resize = (function () {

	'use strict';

	function Resize() {
		//
	}

	Resize.prototype = {

		init: function(outputQuality) {
			this.outputQuality = (outputQuality === 'undefined' ? 0.8 : outputQuality);
		},

		photo: function(file, maxSize, outputType, callback) {

			var _this = this;

			var reader = new FileReader();
			reader.onload = function (readerEvent) {
				_this.resize(readerEvent.target.result, maxSize, outputType, callback);
			}
			reader.readAsDataURL(file);

		},

		resize: function(dataURL, maxSize, outputType, callback) {

			var _this = this;

			var image = new Image();
			image.onload = function (imageEvent) {

				// Resize image
				var canvas = document.createElement('canvas'),
					width = image.width,
					height = image.height;
					
				
				
				//Continuo com a programação normal
				if (width > height) {
					if (width > maxSize) {
						height *= maxSize / width;
						width = maxSize;
					}
				} else {
					if (height > maxSize) {
						width *= maxSize / height;
						height = maxSize;
					}
				}
				// Se preciso inverter os valores
				// https://jsfiddle.net/wunderbart/w1hw5kv1/
				if (4 < orient && orient < 9) {
					canvas.width = height;
					canvas.height = width;
				}else {
					canvas.width = width;
					canvas.height = height;
				}
				
//				canvas.width = width;
//				canvas.height = height;
				var ctx = canvas.getContext('2d');
				// Verifico que tipo de rotação preciso aplicar na imagem
				switch (orient) {
				  case 2: ctx.transform(-1, 0, 0, 1, width, 0); break;
				  case 3: ctx.transform(-1, 0, 0, -1, width, height ); break;
				  case 4: ctx.transform(1, 0, 0, -1, 0, height ); break;
				  case 5: ctx.transform(0, 1, 1, 0, 0, 0); break;
				  case 6: ctx.transform(0, 1, -1, 0, height , 0); break;
				  case 7: ctx.transform(0, -1, -1, 0, height , width); break;
				  case 8: ctx.transform(0, -1, 1, 0, 0, width); break;
				  default: break;
				}
				ctx.drawImage(image, 0, 0, width, height);

				_this.output(canvas, outputType, callback);

			}
			image.src = dataURL;

		},

		output: function(canvas, outputType, callback) {

			switch (outputType) {

				case 'file':
					canvas.toBlob(function (blob) {
						callback(blob);
					}, 'image/jpeg', 0.8);
					break;

				case 'dataURL':
					callback(canvas.toDataURL('image/jpeg', 0.8));
					break;

			}

		}

	};

	return Resize;

}());
