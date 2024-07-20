$(document).ready(function() {
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
		var item_descricao = $('#item_descricao').val();

		// Limpa o input
		$('span.nome-arquivo').html('');
		$('#item_titulo').val('');
		$('#item_descricao').val('');

		if(!!item_titulo && !!item_descricao) {
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
						var hidden3	= $('<input type="hidden" name="itens_descricoes[]" value="' + item_descricao + '" form="form_admin">');
						var remove 	= $('<a href="' + document.basePath + '/admin/sobre/deletaritem/img/' + filename + '" title="Excluir item" class="btn-remove-item btn_excluir no-fancybox"></a>');
						var titulo 	= $('<div style="display: flex; align-items: center; color: #fff; background: #00463f; border-radius: 8px; padding-right: 10px;" class="nome"><img src="' + document.basePath + '/thumb/sobre/3/40/40/' + filename + '" alt="Ícone"><span style="color: #fff;">' + item_titulo + ' </span> - '+ item_descricao +'</div>');

						// Adiciona as divs
						div_row.append(hidden1);
						div_row.append(hidden2);
						div_row.append(hidden3);
						div_row.append(remove);
						// div_row.append(view);
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
