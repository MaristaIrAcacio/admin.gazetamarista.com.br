/*
	* Inicializa Globalmente o Autocomplete
	* Assim ele pode ser chamado de outras páginas
	* Ex: AutocompleteIniciar($(".nomedaclasse").find(input));
*/
function AutocompleteIniciar(input_complete){
	// Armazena as propriedades do elemento
	var ac 	  = input_complete.data('ac');
	var name  = input_complete.attr('name');
	var value = input_complete.val();
	var label = input_complete.data('ac_label');
	var readonly = input_complete.data('readonly');

	var divMultiple = null;
	var multiple_model = input_complete.data('ac_middle');
	var multiple = null;

	if(multiple_model != undefined) {
		multiple = true;
	} else {
		multiple = false;
	}

	// Adiciona o label
	if(label) {
		input_complete.val(label);
	}

	// Muda o auto-complete para descricao
	input_complete
		.attr({
			'name':name + '_label',
			'id':name + '_label',
			'rel':name,
			'field-type':'string',
			'autocomplete':'off'
		})
		.addClass('autocompletelabel');

	if(multiple) {
		divMultiple = $('<div id="teste"></div>')
			.addClass('autocompletemultiplebg');

		input_complete.before(divMultiple);
		divMultiple.append(input_complete);

		if(input_complete.data('json_values') != undefined) {
			$.each(input_complete.data('json_values'), function(index, item) {
				var span = $('<a href="#"></a>')
					.html(
						'<input type="hidden" name="' + name + '[]" value="' + item.identifier + '">' +
						'<input type="hidden" name="' + name + 'l[]" value="' + item.label + '">' +
						item.label)
					.on('click', function() {
						$(this).remove();

						return false;
					})
					.prependTo(divMultiple);
			});
		}
	}else {
		// Cria o input do id
		var input_value = $('<input type="hidden">')
			.attr({'readonly':true, 'name':name, 'id':name, 'name':name, 'field-type':'integer', 'autocomplete':'off'})
			.val(value)
			.addClass('autocompletevalue')
			.addClass('input_css3')
			.addClass('input25')
			.css({'text-align':'center'});
		input_complete.before(input_value);
		input_value.after(input_complete);
	}

	// Cria o auto-complete
	input_complete.autocomplete({
		appendTo: input_complete.closest('form'),
		source: function(request, response) {
			// Ajusta o espaço
			request.term = request.term.replace(' ', '%25');

			// Verifica se tem a data no parametro
			if(input_complete.data('ac_url')) {
				// Monta a url
				var url = input_complete.data('ac_url') + '/term/' + request.term + '/ac/' + ac;

				// Verifica se o hook existe
				if(typeof(document.autocomplete.geturl[name]) == 'function') {
					url = document.autocomplete.geturl[name].call(this, url);
				}
			}
			else {
				// Monta a url
				var url = document.basePath + '/admin/index/autocomplete/term/' + request.term + '/ac/' + ac;

				// Verifica se o hook existe
				if(typeof(document.autocomplete.geturl[name]) == 'function') {
					url = document.autocomplete.geturl[name].call(this, url);
				}

				// Verifica se existe a propriedade ac_name
				if(input_complete.data('ac_name')) {
					url += "/ac_name/" + input_complete.data('ac_name');
				}

				// Verifica se existe a propriedade ac_table
				if(input_complete.data('ac_table')) {
					url += "/ac_table/" + input_complete.data('ac_table');
				}

				// Verifica se existe o campo estado
				if($('#idestado').val() > 0) {
					url += "/idestado/" + $('#idestado').val();
				}

				// Verifica se é um readonly
				if(input_complete.attr('readonly')) {
					url += "/readonly/" + input_complete.attr('readonly');
				}
			}

			// Verifica se a url foi criada
			if(!url == false) {
				// Faz a requisição
				$.ajax({
					url: url,
					dataType: "json",
					success: function(data) {
						var array_data = [];

						// Verifica se é seleção multipla
						if(multiple) {
							// Percorre todos os elementos
							$.each(data, function(index, item) {
								// Verifica se o item ja foi selecionado
								if($('input[name="' + name + '[]"][value="' + item.identifier + '"]').length == 0) {
									array_data.push(item);
								}
							});
						} else {
							// Mapeia todos os elementos do retorno
							array_data = data;
						}

						if(array_data.length == 0) {
							data = ['vazio'];

							response(
								$.map(data, function(item) {
									return {identifier:"zero", label:"** Nenhum item encontrado **"}
								})
							)
						} else {
							response(array_data);
						}
					}
				});
			}
			else {
				input_complete.val('');
				return response([]);
			}
		},
		select: function(event, ui) {
			// Executa ao selecionar o item
			if(typeof(document.autocomplete.select[name]) == 'function') {
				// Busca o hook
				var val_return = document.autocomplete.select[name].call(this, ui.item);

				// Verifica se a seleção foi cancelada
				if(val_return == false) {
					return false;
				}
			}

			if(multiple) {
				var span = $('<a href="#"></a>')
					.html(
						'<input type="hidden" name="' + name + '[]" value="' + ui.item.identifier + '">' +
						'<input type="hidden" name="' + name + 'l[]" value="' + ui.item.label + '">' +
						ui.item.label)
					.on('click', function() {
						$(this).remove();

						return false;
					})
					.prependTo(divMultiple);

				return false;
			}
			else {
				// Seleciona o item
				input_value.val(ui.item.identifier);
			}
		},
		close: function() {
			if(multiple) {
				input_complete.autocomplete('close');
				input_complete.val('');
				input_complete.autocomplete('search', '');
			}
		}
	})
	.on('focus', function() {
		var val = $(this).val();

		input_complete.autocomplete('search', val == '' ? ' ': val);

		if(!multiple) {
			// Verifica se remove o id selecionado
			if(val == '') {
				// Executa ao selecionar o item
				if(typeof(document.autocomplete.clear[name]) == 'function') {

					// Busca o hook
					var val_return = document.autocomplete.clear[name].call(this);

					// Verifica se a seleção foi cancelada
					if(val_return == false) {
						return false;
					}
				}

				// Limpa o campo de valor
				input_value.val('');
			}else{

			}
		}
	})
	.on('blur', function() {
		var val = $(this).val();
		if(val == '') {
			// Limpa o campo de valor
			input_value.val('');
		}
	});
}


// Iinicializa após carregar o JQUERY
$(function() {

	// Quando Clicar no icone de informação que aparece acima do autocomplete, abre o SWAL.
	$('.labeldiv .autocomplete-info').on('click', function(e) {
		let mensagem = $(this).attr('data-msg');

		if(!mensagem){
			mensagem = "Este campo é um Autocomplete, \n começe a digitar a palavra desejada que as opções irão começar a aparecer.";
		}

		swal({
			title: "Atenção!",
			text: mensagem,
			button: "Entendi!",
			icon: "info"
		});
	});


	document.autocomplete 		 = {}
	document.autocomplete.geturl = {};
	document.autocomplete.select = {};
	document.autocomplete.clear  = {};

	// Auto complete
	$('*[data-ac]').each(function() {
		var input_complete = $(this);

		// Incializa a Função para esse Campo
		AutocompleteIniciar(input_complete);

	})
});
