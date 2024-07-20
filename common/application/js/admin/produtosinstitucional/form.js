$(function() {
	// Insere o id no formulário no primeiro form
	$('form:first').attr('id', 'form_admin');

	// Parse id youtube
	function youtube_parser(url){
		var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
		var match = url.match(regExp);
		return (match&&match[7].length==11)? match[7] : false;
	}
	
	/*
	 * Galeria de fotos
	 */	

	// Adiciona evento ao click do remove imagem
	$(document).on('click', '.acoes-galeria .btn-remove-image', function (e) {
		e.preventDefault();

		let obj = $(this);

		// Faz a requisição à exclusão
		$.ajax({
			url: obj.attr('data-src'),
			type: 'POST',
			success: function() {
				obj.closest('li').fadeOut(function() {
					$(this).remove();
					if($('#fotos .photos li').length === 0)
						$('#fotos .photos').parent().before('<div class="small-12 columns no-photos"><p>(nenhuma imagem cadastrada)</p></div>');
				});
			},
			error: function(){
				swal('Erro!', 'Ocorreu um erro, tente novamente!', 'error');
				return false;
			}
		});
	});

	// Função para reordenar itens 'fotos'
	$("#fotos .photos").sortable({
		opacity: 0.6,
		cursor: 'move',
		update: function(){
			let url = $("#fotos .photos").data("order-url");

			let idmodel = $("#id").val();

			// Converter os IDs em array
			let order = $(this).sortable("toArray");

			// Mandando um POST para o webservice com a nova ordem
			$.ajax({
				url	   : url,
				type   :	 'POST',
				data   : {'idmodel': idmodel, 'objOrdem': order},
				success: function() {
					// ok
				},
				error: function(){
					swal('Erro!', 'Ocorreu um erro, tente novamente!', 'error');
					return false;
				}
			});
		}
	});

	// Salva a legenda da foto
	$(document).on('blur', 'input[name=img_legenda]', function () {
		let click 		= $(this),
			idmodel 	= $("#id").val(),
			iditem 		= $(this).data('iditem'),
			txt_legenda = $(this).val(),
			url         = $(this).data('url');

		// Dispara o ajax
		$.ajax({
			url	   : url,
			type   : 'POST',
			data   : {'id': idmodel, 'iditem': iditem, 'legenda': txt_legenda},
			success: function(e) {
				if(e == "erro") {
					click.animate({'background-color':'red'}, 200).animate({'background-color':'white'}, 500);
				}else{
					click.animate({'background-color':'green'}, 200).animate({'background-color':'white'}, 500);
				}
			},
			error: function(){
				swal('Erro!', 'Ocorreu um erro, tente novamente!', 'error');
				return false;
			}
		});
	});

	//** Upload das fotos **//
	// Ao clicar no campo temporário
	$(document).on('click', '.arquivo-upload-avancado .arquivo_tmp', function () {
		$(this).closest('.arquivo-upload-avancado').find('input[type="file"]').click();
	});
	// Ao soltar arquivos
	$('.arquivo-upload-avancado .arquivo_tmp').on('drag dragstart dragend dragover dragenter dragleave drop', function (e) {
		e.preventDefault();
		e.stopPropagation();
	})
		.on('drop', function(e) {
			let obj            = $(this);
			let arquivo_upload = obj.closest('.arquivo-upload-avancado');

			arquivoUploadAvancadoUpload(arquivo_upload, e.originalEvent.dataTransfer.files);
		});

	// Ao selecionar os arquivos
	$(document).on('change', '.arquivo-upload-avancado input[type="file"]', function (e) {
		let obj            = $(this);
		let arquivo_upload = obj.closest('.arquivo-upload-avancado');

		arquivoUploadAvancadoUpload(arquivo_upload, e.target.files);

		// Reseta o campo
		arquivo_upload.find('input[type="file"]').val('');
	});

	window.arquivoUploadAvancadoUpload = function(arquivo_upload, files) {
		let upload_url = arquivo_upload.attr('data-upload-url');
		let photos     = $('#fotos .linha-fotos .photos');

		// Adiciona o loading
		arquivo_upload.find('.arquivo_tmp').toggleClass('off').append('<div class="loading-box"><div class="loading-animacao"></div></div>');

		let data = new FormData();

		$.each(files, function(i, file) {
			data.append('arquivos[' + i + ']', file);
		});

		$.ajax({
			url        : upload_url,
			method     : 'post',
			data       : data,
			dataType   : 'json',
			cache      : false,
			contentType: false,
			processData: false,
		}).always(function() {
			// Remove o loading
			arquivo_upload.find('.arquivo_tmp').toggleClass('off').find('.loading-box').remove();
		}).fail(function(jqXHR, textStatus) {
			const error = ajaxGetError(jqXHR);

			if( textStatus !== 'abort' )
			{
				swal(error.error_title, error.error_message, error.error_icon);
			}
		}).done(function(data) {
			if( data.status === 'sucesso' )
			{
				$('.no-photos').remove();

				let itens = '';

				if( data.itens.length )
				{
					for( let i = 0; i < data.itens.length; i++ )
					{
						itens += `
                            <li class="column ui-sortable-handle">
                            	<div class="panel">
                            		<div class="row collapse">
										<div class="small-12 columns acoes-galeria">
											<a data-src="${document.basePath}/admin/produtosinstitucional/removeimage/foto/${data.itens[i].ref}" class="btn-remove-image" title="Excluir">
												<span class="delete"></span>
											</a>
										</div>
                            			<div class="small-12 columns text-center imagem">
											<a href="${data.itens[i].path}" data-fancybox="preview">
												<img src="${data.itens[i].path}" alt="${data.itens[i].nome}">
											</a>
										</div>
										<div class="small-12 columns legenda">
											<div class="element-form" id="element-legenda-${data.itens[i].id}">
												<div class="labeldiv">
                                                	<label>Legenda</label>
                                            	</div>
                                            	<div class="input-form">
                                                	<input type="text" name="novalegenda[]" value="" field-type="text" class="varchar string legenda" form="form_admin">
                                            	</div>
											</div>
										</div>
										<input type="hidden" name="new-fotos[]" value="${data.itens[i].ref}" class="hide" form="form_admin">
									</div>
								</div>
                            </li>
                        `;
					}
				}

				photos.append(itens);
			}
			else
			{
				swal(data.titulo, data.mensagem, 'error');
			}
		});
	};

	/*
	 * ********** Arquivos downloads **********
	 */

	// Adiciona o evento de adicionar à lista
	$('#downloads').on('click', 'a.btn-add-arquivo', function(e) {
		// Cancela o click do anchor
		e.preventDefault();

		// Busca as informações
		var doc_arquivo	= $('#doc_arquivo').val();
		var doc_titulo 	= $('#doc_titulo').val();

		if(!!doc_arquivo) {
			var ext = doc_arquivo.split('.').pop().toLowerCase();
			if($.inArray(ext, ['pdf','zip', 'rar', 'doc','docx', 'jpg', 'jpeg', 'png', 'xls', 'xlsx']) == -1) {
			    swal('Ops!', 'Extensão (.'+ext+') do arquivo não permitida!', 'error');
            	return false;
			}else{
				if($('.no-arquivos').length > 0) {
					$('.no-arquivos').remove();
				}

				// Cria os wrapper padrões
				var div_row = $('<div class="row arquivo-container lista-simples-item"></div>');

				// Move o input file para o outro formulario e envia
				var obj 	= $('#doc_arquivo');
				var clonar  = obj.clone();
				$(obj).closest('.button.input-file-upload').append(clonar);
				$('#form-uploadarquivo').html(obj.addClass('hide'));
				$('#form-uploadarquivo').trigger('submit');

				$('iframe[name="uploadarquivo-frame"]').off('load').on('load', function() {
					var filename = $(this).contents().text();
					if(filename != 'erro') {
						$('#form-uploadarquivo').html('');

						// Extensao
						var doc_extensao = filename.split(/[. ]+/).pop();

						// Cria os dados na listagem
						var hidden1	= $('<input type="hidden" name="arquivos_titulos[]" value="' + doc_titulo + '" form="form_admin">');
						var hidden2	= $('<input type="hidden" name="file_arquivos[]" value="' + filename + '" form="form_admin">');
						var remove 	= $('<a href="' + document.basePath + '/admin/produtosinstitucional/deletardownload/arquivo/' + filename + '" title="Excluir" class="btn-remove-arquivo"><span class="delete"></span></a>');
						var view 	= $('<a href="#" style="float:left;margin-left:22px;">..</a>');
						var titulo 	= $('<div class="nome"><span>' + doc_titulo + ' (.' + doc_extensao + ')</span></div>');

						// Adiciona as divs
						div_row.append(hidden1);
						div_row.append(hidden2);
						div_row.append(remove);
						div_row.append(view);
						div_row.append(titulo);

						$('.arquivos').append(div_row);

						// Limpa o input
						$('span.nome-arquivo').html('');
						$('#doc_arquivo').val('');
						$('#doc_titulo').val('');
					}else{
						swal('Ops!', 'Ocorreu um erro, tente novamente!', 'error');
            			return false;
					}
				});
			}
		}else{
			swal('Ops!', 'Informe o arquivo e título para adicionar!', 'warning');
            return false;
		}
	});

	// Evento que remove o downloads
	$('#downloads').on('click', 'a.btn-remove-arquivo', function(e) {
		if(!confirm('Deseja remover este arquivo?')) {
			return false;
		}else{
			e.preventDefault();

			// Armazena as informações
			var anchor = $(this);

			// Faz a requisição à exclusão
			$.ajax({
				url: anchor.attr('href'),
				type: 'POST',
				success: function(data) {
					anchor.closest('.arquivo-container').fadeOut(function() {
						$(this).remove();
						if($('.arquivo-container').length == 0) {
							$('.arquivos').append('<div class="small-12 columns no-arquivos"><p>(nenhum arquivo cadastrado)</p></div>');
						}
					});
				},
				error: function() {
					swal('Erro!', 'Ocorreu um erro, tente novamente!', 'error');
					return false;
				}
			});
		}
	});

	/*
	 * ********** Arquivos videos **********
	 */

	// Adiciona o evento de adicionar à lista
	$('#videos').on('click', 'a.btn-add-video', function(e) {
		// Cancela o click do anchor
		e.preventDefault();

		// Busca as informações
		var video_arquivo		= $('#video_arquivo').val();
		var video_url 			= $('#video_url').val();
		var video_nova_legenda 	= $('#video_nova_legenda').val();

		if(!!video_url) {
			if($('.no-videos').length > 0) {
				$('.no-videos').remove();
			}

			// Cria o wrapper padrão
			var li = $('<li></li>');

			var filename = '';
			if(!!video_arquivo) {
				var ext = video_arquivo.split('.').pop().toLowerCase();
				if ($.inArray(ext, ['jpg', 'jpeg', 'png']) == -1) {
					swal('Ops!', 'Extensão ('+ext+') do arquivo inválida!', 'error');
					return false;
				} else {
					// Move o input file para o outro formulario e envia
					var obj = $('#video_arquivo');
					var clonar = obj.clone();
					$(obj).closest('.button.input-file-upload').append(clonar);
					$('#form-uploadthumb').html(obj.addClass('hide'));
					$('#form-uploadthumb').trigger('submit');

					$('iframe[name="uploadthumb-frame"]').off('load').on('load', function () {
						filename = $(this).contents().text();
						$('#form-uploadthumb').html('');

						if (!!filename) {
						    var hidden_thumb = $('<input type="hidden" name="novothumb[]" value="' + filename + '" class="hide" form="form_admin">');
							li.append(hidden_thumb);

							var imgthumb = document.basePath + '/thumb/produto_institucional/2/480/360/' + filename;
							$('div').find('[data-thumb="'+video_url+'"]').attr('src', imgthumb);
						}
					});
				}
			}

			var obj 	= $(this);
			var videos 	= obj.parent().parent().parent().find('.photos');

			var id_youtube = youtube_parser(video_url);

			// Thumb Youtube
			var imgthumb = `<img src="https://i.ytimg.com/vi/${id_youtube}/hqdefault.jpg" alt="Thumb video" data-thumb="${video_url}">`;

			// Cria os wrapper padrões
            var item = `
                <li class="column ui-sortable-handle">
                    <div class="panel">
                        <div class="row collapse">
                            <div class="small-12 columns acoes-galeria">
                                <a href="${document.basePath}/admin/produtosinstitucional/removevideo/thumb/${filename}" class="btn-remove-video" title="Excluir">
                                    <span class="delete"></span>
                                </a>
                            </div>
                            <div class="small-12 columns text-center imagem">
                                <a href="${video_url}" target="_blank" class="video-admin item-preview-video" title="${video_nova_legenda}">
                                    ${imgthumb}
                                </a>
                            </div>
                            <div class="small-12 columns legenda">
                                <div class="element-form" id="element-legenda">
                                    <div class="labeldiv">
                                        <label>Legenda</label>
                                    </div>
                                    <div class="input-form">
                                        <input type="text" name="video_legenda[]" value="${video_nova_legenda}" field-type="text" class="varchar string legenda" form="form_admin">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="urlvideos[]" value="${video_url}" class="hide" form="form_admin">
                        </div>
                    </div>
                </li>
            `;

            li.append(item);
			videos.append(li);

			// Limpa o input
			$('#video_arquivo').val('');
			$('.nome-arquivo').text('');
			$('#video_url').val('');
			$('#video_nova_legenda').val('');
		}else{
			swal('Ops!', 'Informe a url para adicionar!', 'warning');
            return false;
		}
	});

	// Salva a legenda do video
	$("input[name=video_legenda]").blur(function() {
		let click 		= $(this),
			idmodel 	= $("#id").val(),
			iditem 		= $(this).data('iditem'),
			txt_legenda = $(this).val()

		// Dispara o ajax
		$.ajax({
			url		: document.basePath + "/admin/produtosinstitucional/salvalegendavideo/",
			type	: 'POST',
			data	: {'id': idmodel, 'iditem': iditem, 'legenda': txt_legenda},
			success: function(data) {
				if(data == "erro") {
					click.animate({'background-color': 'red'}, 200).animate({'background-color': 'white'}, 500);
				}else {
					click.animate({'background-color': 'green'}, 200).animate({'background-color': 'white'}, 500);
				}
			},
			error: function(){
				swal('Erro!', 'Ocorreu um erro, tente novamente!', 'error');
				return false;
			}
		});
	});

	// Função para reordenar itens
	$("#videos .photos").sortable({
		opacity: 0.6,
		cursor: 'move',
		update: function() {
			var id = $("#id").val();

			// Converter os IDs da imagens em array
			var order = $(this).sortable("toArray");

			// Mandando um POST para o webservice com a nova ordem
			$.ajax({
				url		: document.basePath + "/admin/produtosinstitucional/salvaordemvideo",
				type	: 'POST',
				data	: {'id': id, 'objOrdem': order},
				success: function() {
					// ok
				},
				error: function() {
					swal('Erro!', 'Ocorreu um erro, tente novamente!', 'error');
					return false;
				}
			});
		}
	});

	// Evento que remove o video
	$('#videos').on('click', 'a.btn-remove-video', function(e) {
		if(!confirm('Deseja remover este vídeo?')) {
			return false;
		}else{
			e.preventDefault();

			// Armazena as informações
			var anchor = $(this);

			// Faz a requisição à exclusão
			$.ajax({
				url: anchor.attr('href'),
				type: 'POST',
				success: function(data) {
					anchor.closest('li').fadeOut(function() {
						$(this).remove();
						if($('#videos .photos li').length == 0)
							$('#videos .photos').parent().before('<div class="small-12 columns no-videos"><p>(nenhum vídeo cadastrado)</p></div>');
					});
				},
				error: function() {
					swal('Erro!', 'Ocorreu um erro, tente novamente!', 'error');
					return false;
				}
			});
		}
	});




	// /*
	//  * ********** Itens **********
	//  */

	// // Adiciona o evento de adicionar à lista
	// $('#diferenciais').on('click', 'a.btn-add-item', function(e) {
	// 	// Cancela o click do anchor
	// 	e.preventDefault();

	// 	// Busca as informações
	// 	var item_imagem	= $('#item_imagem').val();
	// 	var item_titulo = $('#item_titulo').val();

	// 	// Limpa o input
	// 	$('span.nome-arquivo').html('');
	// 	$('#item_titulo').val('');
	// 	$('#item_descricao').val('');

	// 	if(!!item_titulo) {
	// 		var ext = item_imagem.split('.').pop().toLowerCase();
	// 		if($.inArray(ext, ['png']) == -1) {
	// 		    swal('Ops!', 'Extensão (.'+ext+') de imagem inválida!', 'error');
    //         	return false;
	// 		}else{
	// 			if($('.no-itens').length > 0) {
	// 				$('.no-itens').remove();
	// 			};

	// 			// Cria os wrapper padrões
	// 			var div_row = $('<div class="row item-container lista-simples-item"></div>');

	// 			// Move o input file para o outro formulario e envia
	// 			var obj 	= $('#item_imagem');
	// 			var clonar  = obj.clone();
	// 			$(obj).closest('.button.input-file-upload').append(clonar);
	// 			$('#form-uploaditem').html(obj.addClass('hide'));
	// 			$('#form-uploaditem').trigger('submit');
				
	// 			$('iframe[name="uploaditem-frame"]').off('load').on('load', function() {
	// 				var filename = $(this).contents().text();
	// 				if(filename != 'erro') {
	// 					$('#form-uploaditem').html('');

	// 					console.log('Teste');

	// 					// Limpa o campo da Imagem
	// 					$('#item_imagem').val('');

	// 					// Extensao
	// 					var doc_extensao = filename.split(/[. ]+/).pop();

	// 					// Cria os dados na listagem
	// 					var hidden1	= $('<input type="hidden" name="itens_titulos[]" value="' + item_titulo + '" form="form_admin">');
	// 					var hidden2	= $('<input type="hidden" name="itens_imagens[]" value="' + filename + '" form="form_admin">');
	// 					var remove 	= $('<a href="' + document.basePath + '/admin/sobre/deletaritem/img/' + filename + '" title="Excluir item" class="btn-remove-item btn_excluir no-fancybox"></a>');
	// 					var titulo 	= $('<div style="display: flex; align-items: center; color: #fff; background: #00463f; border-radius: 8px; padding-right: 10px;" class="nome"><img src="' + document.basePath + '/thumb/sobre/3/40/40/' + filename + '" alt="Ícone"><span style="color: #fff;">' + item_titulo + ' </span></div>');

	// 					// Adiciona as divs
	// 					div_row.append(hidden1);
	// 					div_row.append(hidden2);
	// 					div_row.append(remove);
	// 					div_row.append(titulo);


	// 					$('.lista-simples').append(div_row);
	// 				}else{
	// 					swal('Ops!', 'Ocorreu um erro, tente novamente!', 'error');
    //         			return false;
	// 				}
	// 			});
	// 		}
	// 	}else{
	// 		swal('Ops!', 'Informe os dados para adicionar!', 'warning');
    //         return false;
	// 	}
	// });

	// // Evento que remove o link
	// $('#diferenciais').on('click', 'a.btn-remove-item', function(e) {
	// 	if(!confirm('Deseja remover este item?')) {
	// 		return false;
	// 	}else{
	// 		e.preventDefault();

	// 		// Armazena as informações
	// 		var anchor = $(this);

	// 		// Faz a requisição à exclusão
	// 		$.ajax({
	// 			url: anchor.attr('href'),
	// 			type: 'POST',
	// 			success: function(data) {
	// 				anchor.closest('.item-container').fadeOut(function() {
	// 					$(this).remove();
	// 					if($('.item-container').length == 0) {
	// 						$('.diferenciais').append('<div class="small-12 columns no-links"><p>(nenhum item cadastrado)</p></div>');
	// 					}
	// 				});
	// 			},
	// 			error: function() {
	// 				swal('Erro!', 'Ocorreu um erro, tente novamente!', 'error');
	// 				return false;
	// 			}
	// 		});
	// 	}
	// });


	/*
	 * ********** Itens **********
	 */

	// Adiciona o evento de adicionar à lista
	$('#diferenciais').on('click', 'a.btn-add-item', function(e) {
		// Cancela o click do anchor
		e.preventDefault();

		// Busca as informações
		var item_imagem	= $('#item_imagem').val();
		var item_titulo = $('#item_titulo').val();

		// Limpa o input
		$('span.nome-arquivo').html('');
		$('#item_titulo').val('');

		if(!!item_titulo) {
			var ext = item_imagem.split('.').pop().toLowerCase();
			if($.inArray(ext, ['png']) == -1) {
			    swal('Ops!', 'Extensão (.'+ext+') de imagem inválida!', 'error');
            	return false;
			}else{
				if($('.no-itens').length > 0) {
					$('.no-itens').remove();
				}

				// Cria os wrapper padrões
				var div_row = $('<div class="row item-container lista-simples-item"></div>');

				// Move o input file para o outro formulario e envia
				var obj 	= $('#item_imagem');
				var clonar  = obj.clone();
				$(obj).closest('.button.input-file-upload').append(clonar);
				$('#form-uploaditem').html(obj.addClass('hide'));
				$('#form-uploaditem').trigger('submit');

				$('iframe[name="uploaditem-frame"]').off('load').on('load', function() {
					var filename = $(this).contents().text();
					if(filename != 'erro') {
						$('#form-uploaditem').html('');

						// Limpa o campo da Imagem
						$('#item_imagem').val('');

						// Extensao
						var doc_extensao = filename.split(/[. ]+/).pop();

						// Cria os dados na listagem
						var hidden1	= $('<input type="hidden" name="itens_titulos[]" value="' + item_titulo + '" form="form_admin">');
						var hidden2	= $('<input type="hidden" name="itens_imagens[]" value="' + filename + '" form="form_admin">');
						var remove 	= $('<a href="' + document.basePath + '/admin/produtosinstitucionais/deletaritem/img/' + filename + '" title="Excluir item" class="btn-remove-item btn_excluir no-fancybox"></a>');
						var titulo 	= $('<div style="display: flex; align-items: center; gap: 20px;" class="nome"><img src="' + document.basePath + '/thumb/produto_institucional/3/40/40/' + filename + '" alt="Ícone"><span>' + item_titulo + ' </span></div>');

						// Adiciona as divs
						div_row.append(hidden1);
						div_row.append(hidden2);
						div_row.append(remove);
						div_row.append(titulo);

						$('.itens').append(div_row);
					}else{
						swal('Ops!', 'Ocorreu um erro, tente novamente!', 'error');
            			return false;
					}
				});
			}
		}else{
			swal('Ops!', 'Informe os dados para adicionar!', 'warning');
            return false;
		}
	});

	// Evento que remove o link
	$('#diferenciais').on('click', 'a.btn-remove-item', function(e) {
		if(!confirm('Deseja remover este item?')) {
			return false;
		}else{
			e.preventDefault();

			// Armazena as informações
			var anchor = $(this);

			// Faz a requisição à exclusão
			$.ajax({
				url: anchor.attr('href'),
				type: 'POST',
				success: function(data) {
					anchor.closest('.item-container').fadeOut(function() {
						$(this).remove();
						if($('.item-container').length == 0) {
							$('.diferenciais').append('<div class="small-12 columns no-links"><p>(nenhum item cadastrado)</p></div>');
						}
					});
				},
				error: function() {
					swal('Erro!', 'Ocorreu um erro, tente novamente!', 'error');
					return false;
				}
			});
		}
	});

	// Função para reordenar itens
	$("#diferenciais .itens").sortable({
		opacity: 0.6,
		cursor: 'move',
		update: function() {
			let url = $("#diferenciais .itens").data("order-url");

			let idmodel = $("#id").val();

			// Converter os IDs em array
			let order = $(this).sortable("toArray");

			console.log(order)

			// Mandando um POST para o webservice com a nova ordem
			$.ajax({
				url		: document.basePath + "/admin/sobre/salvaordemimage",
				type	: 'POST',
				data	: {'id': id, 'objOrdem': order},
				success: function() {
					// ok
				},
				error: function() {
					swal('Erro!', 'Ocorreu um erro, tente novamente!', 'error');
					return false;
				}
			});
		}
	});

});
