$(document).ready(function() {
	/*
	 * ------------------------------------------------------
	 *  Menu offCanvas
	 * ------------------------------------------------------
	 */
	if( typeof MenuOffCanvasSwipe == 'function' )
	{
		new MenuOffCanvasSwipe();
		timeMenu = setTimeout(function(){},1)
		$('.icon-bar:not(.nodirecthover)').on({
			mouseenter : function(){
				elementoAbrir = $(this).find('.btn-abrir-menu');
				clearTimeout(timeMenu);
				timeMenu = setTimeout(function(){
					elementoAbrir.trigger('click');
				},6000)
			},
			mouseleave : function(){
				clearTimeout(timeMenu);
			}
		});

		/* barra de rolagem menu */
			$(".menu-navegacao-off-left").mCustomScrollbar({
				autoHideScrollbar: true,
				scrollInertia: 0,
				mouseWheel:{ preventDefault: true }
			})
		/* barra de rolagem menu */

		/* Click menu */
			$('ul.off-canvas-list a[href="#"]').on('click', function(e) {
				var elementoPai = $(this).parent()
					elementoSubMenu = elementoPai.find('ul');

				if( elementoSubMenu.is(':visible') ){
					elementoSubMenu.slideUp('normal').promise().done(function(){
						elementoPai.removeClass('active')
					});
				}else if( !elementoSubMenu.is(':visible') ){
					$('ul.off-canvas-list li').removeClass('active');
					$('ul.off-canvas-list li ul').slideUp('normal');

					elementoSubMenu.slideDown('normal').promise().done(function(){
						elementoPai.addClass('active')
					});
				}
				return false;
			});
		/* Click menu */
	}

	/*
	 * ------------------------------------------------------
	 *  Language Datepicker
	 * ------------------------------------------------------
	 */
	$.datepicker.regional['pt-BR'] = {
		closeText: 'Fechar',
		prevText: '&#x3c;Anterior',
		nextText: 'Pr&oacute;ximo&#x3e;',
		currentText: 'Hoje',
		monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho',
		'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
		monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
		'Jul','Ago','Set','Out','Nov','Dez'],
		dayNames: ['Domingo','Segunda-feira','Ter&ccedil;a-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'],
		dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
		dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
		weekHeader: 'Sm',
		dateFormat: 'dd/mm/yy',
		firstDay: 0,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''
	};
	$.datepicker.setDefaults($.datepicker.regional['pt-BR']);

	$.timepicker.regional['pt-BR'] = {
		timeOnlyTitle: 'Escolha o horário',
		timeText: 'Horário',
		hourText: 'Hora',
		minuteText: 'Minutos',
		secondText: 'Segundos',
		millisecText: 'Milissegundos',
		microsecText: 'Microssegundos',
		timezoneText: 'Fuso horário',
		currentText: 'Agora',
		closeText: 'Fechar',
		timeFormat: 'HH:mm',
		timeSuffix: '',
		amNames: ['a.m.', 'AM', 'A'],
		pmNames: ['p.m.', 'PM', 'P'],
		isRTL: false
	};
	$.timepicker.setDefaults($.timepicker.regional['pt-BR']);

	/*
	 * ------------------------------------------------------
	 *  Slick
	 * ------------------------------------------------------
	 */
	if( $.fn.slick )
	{
		$("[data-slick]").slick();
	}

	// Funções de Lista 
	funcoesLista();

	// Funções de Formulário 
	funcoesForm();

	// Inicia as mascaras
	initMascaras();

	// Altera o campo textarea para input text
	var nome_textarea = $('table.list tr.filter textarea').attr('name');
	$("#" + nome_textarea).remove();
	var filtro_textinput = $("<input type='text' placeholder='Buscar "+nome_textarea+"' class='varchar string' field-type='text' value='' id='"+nome_textarea+"' name='"+nome_textarea+"'>");
	$("#element-" + nome_textarea).append(filtro_textinput);

	if( $('input.datepicker').length > 0 ) {
		// Adiciona o datepiker
		$('input.datepicker').datepicker();
	}

	// Ajustando campos do tipo ENUM apenas dos formulários
	$("input").each(function() {
		// Se o elemento tiver o atributo class definido
		if($(this).attr("class") !== undefined) {
			// verifica se o valor do atributo class contem a palavra enum
			if($(this).attr("class").search("enum") == 0){
				// Captura o value do input
				var value_input = $(this).val();

				// recebe o valor setado na class. Exemplo class="enum('HOME1','HOME2') string"
				var select = $(this).attr("class");

				// remove o começo
				var parts = select.split("enum(");

				// remove o final
				var part1 = parts[1].split(") ");

				// armazena o essencial
				var result = part1[0];

				// remove as aspas
				result = replaceAll(result,"'","");

				// separa os elementos por virgula
				result = result.split(',');

				if(result.length <= 5){
					// cria o novo seletor
					var novoelemento = $("<div class='radio_button' id='" + $(this).attr('id') + "'> </div>");
				}else{
					// cria o novo seletor
					var novoelemento = $("<select name='" + $(this).attr('name') + "' id='" + $(this).attr('id') + "' field-type='" + $(this).attr('field-type') +
						"' class=\"" + $(this).attr('class') + "\">");
				}

				// adiciona as opções no seletor
				var options;
				for(i=0;i<result.length;i++) {
					var marca_selected = "";
					var marca_checked = "";
					if(result[i] == value_input) {
						marca_selected = "selected";
						marca_checked  = "checked";
					}

					if(result.length <= 5){
						novoelemento.append('<div class="input-radio-custom"><input type="radio" '+marca_checked+' name="' +
							$(this).attr('name') +'" value="'+ result[i] + '" id="'+ $(this).attr('name')+result[i] +'" field-type="radio"><span></span><label for="'
							+ $(this).attr('name')+result[i] +'">'+ result[i] +'</label><div class="div_input_radio"></div></div>');
					}else{
						novoelemento.append('<option value="' + result[i] +'" '+marca_selected+'>'+ result[i] +'</option>');
					}
				}

				// adiciona o seletor na div
				$(this).parent().append(novoelemento);

				// remove o input anterior
				$(this).remove();
			}
		}
	});
});

function replaceAll( text, busca, reemplaza ){
	while (text.toString().indexOf(busca) != -1)
		text = text.toString().replace(busca,reemplaza);
	return text;
}

/*
 * ------------------------------------------------------
 *  Funções da lista
 * ------------------------------------------------------
 */
function funcoesLista(){

	// Editar / Visualizar - Click/Acesso
	if( $('div.table-list table.list tr td:not(:first-child)').length > 0 && (window._GLOBALS.permitidoEditar == true || window._GLOBALS.permitidoVisulizar == true) || window._GLOBALS.currentController == 'index' ) {
		$('div.table-list table.list tr td:not(:first-child):not(.coluna-acoes)').on('click', function( event ){
			event.preventDefault();
			event.stopImmediatePropagation();

			var url = (($(this).parent().data('editar') != '') ? $(this).parent().data('editar') : $(this).parent().data('visualizar'))
			if( url != '' && url != undefined ){
				// return false;
				window.location = url;
			}
		});
	}

	if( $('div.dasboard-list table.list tr').length > 0  && (window._GLOBALS.permitidoEditar == true || window._GLOBALS.permitidoVisulizar == true) || window._GLOBALS.currentController == 'index' ) {
		$('div.dasboard-list table.list tr').on('click', function( event ){
			event.preventDefault();
			event.stopImmediatePropagation();
			var url = (($(this).parent().data('editar') != '') ? $(this).parent().data('editar') : $(this).parent().data('visualizar'))
			if( url != '' && url != undefined ){
				window.location = url;
			}

			var url_dashboard = $(this).data('link');
			if( url_dashboard != '' && url_dashboard != undefined ){
				window.location = url_dashboard;
			}
		});
	}

	// Botão visualizar da listagem
	if( $('a.btn-view').length > 0 && window._GLOBALS.permitidoVisulizar == true ) {
		$('a.btn-view').on('click', function() {
			var tabela = $('table.list'),
				checkbox = tabela.find('tbody input[type="checkbox"]:checked, tbody input[type="radio"]:checked').first().parents('tr')
				url = checkbox.data('visualizar')
			;

			if( checkbox.length > 0 ){
				location.href = url;
			}else{
				swal('Ops!', 'Selecione um registro para visualizar.', 'warning');
			}

			return false;
		});
	}

	$('input[type="checkbox"]').on('click', function() {
		var numberChecked = $('table.list tbody input[type="checkbox"]:checked').length;
		if(numberChecked > 1){
			$(".btn-view").hide();
		}else{
			$(".btn-view").show();
		}
	});

	// Botão visualizar individual
	if( $('a.btn-visualizar-individual').length > 0 && window._GLOBALS.permitidoVisulizar == true ) {
		$('a.btn-visualizar-individual').each(function() {
			let obj = $(this);

			obj.on('click', function(e) {
				e.preventDefault();
				e.stopImmediatePropagation();

				var url = obj.attr('href');
				if( url != '' && url != undefined ) {
					window.location = url;
				}
			});
		});
	}

	// Botão remover da listagem
	if( $('a.btn-remove').length > 0 && window._GLOBALS.permitidoExcluir == true ) {
		$('a.btn-remove').on('click', function() {
			var url = $(this).attr('href'),
				tabela = $('table.list'),
				removido = true,
				checkbox = tabela.find('tbody input[type="checkbox"]:checked, tbody input[type="radio"]:checked')
			;

			if( checkbox.length == 1 ){
				if(!confirm('Deseja remover o registro?')) {
					return false;
				}
			}else if( checkbox.length > 1 ){
				if(!confirm('Deseja remover estes registros?')) {
					return false;
				}
			}else{
				swal('Ops!', 'Selecione ao menos um registro.', 'warning');
				return false;
			}

			checkbox.each(function( index, e ){
				var id = $(this).val()
					line = $(this).closest('tr')
				;
				$.ajax({
					url: url + id,
					async: false,
					success: function(data) {
						if(data.result) {
							line.css({'background-color':'#ff9595'});
							line.fadeOut( 1000, function() {
								$(this).remove();
							});
						}else{
							if(data.message != "") {
								$.msgBox({message:data.message, type:'error'});
							}else{
								$.msgBox({message:'Não foi possível remover o registro', type:'error'});
							}
						}
					}
				});
			});

			return false;
		});
	}

	// Botão remover individual
	if( $('a.btn-remove-invidual').length > 0 && window._GLOBALS.permitidoExcluir == true ) {
		$('a.btn-remove-invidual').each(function() {
			let obj = $(this);

			obj.on('click', function(e) {
				e.preventDefault();
				e.stopImmediatePropagation();

				var url = obj.attr('href'),
				line    = obj.closest('tr'),
				id      = obj.attr('data-id').replace('idemail_','');

				if(!confirm('Deseja remover o registro?')) {
					return false;
				}

				$.ajax({
					url: url + id,
					async: false,
					success: function(data) {
						if(data.result) {
							line.css({'background-color':'#ff9595'});
							line.fadeOut( 1000, function() {
								$(this).remove();
							});
						}else{
							if(data.message != "") {
								$.msgBox({message:data.message, type:'error'});
							}else{
								$.msgBox({message:'Não foi possível remover o registro', type:'error'});
							}
						}
					}
				});

				return false;
			});
		});
	}

	// Selecionar todos os itens da listagem
	if( $('input.selecionatodoslist').length > 0 ) {
		$('input.selecionatodoslist').off().on('click', function(){
			var check = $(this).is(':checked')
				checkboxs = $(this).parents('table.list').find('tbody input[type="checkbox"]')
			;
			checkboxs.prop('checked', check);

			var numberChecked = $('table.list tbody input[type="checkbox"]:checked').length;
			if(numberChecked > 1){
				$(".btn-view").hide();
			}else{
				$(".btn-view").show();
			}

			//$('table.list tbody input[type="checkbox"]').trigger('click');
		});
	}

	// Ajustando campos do tipo ENUM apenas nos filtro de listagens
	if( $("#filtros").length > 0 ) {
		$("#filtros input").each(function(){
			// Se o elemento tiver o atributo class definido
			if($(this).attr("class") !== undefined){
				// Captura o value do input
				var value_input = $(this).val();

				// verifica se o valor do atributo class contem a palavra enum
				if($(this).attr("class").search("enum") == 0){
					// recebe o valor setado na class. Exemplo class="enum('HOME1','HOME2') string"
					var select = $(this).attr("class");

					// Adiciona um item vazio na combo
					select = select.replace("enum(", "enum('*Geral*',");

					// remove o começo
					var parts = select.split("enum(");

					// remove o final
					var part1 = parts[1].split(") ");

					// armazena o essencial
					var result = part1[0];

					// remove as aspas
					result = replaceAll(result,"'","");

					// separa os elementos por virgula
					result = result.split(',');

					// Novo elemento ENUM
					if(result.length <= 5){
						// cria o novo seletor
						var novoelemento = $("<div class='radio_button' id='" + $(this).attr('id') + "'> </div>");
					}else{
						// cria o novo seletor
						var novoelemento = $("<select name='" + $(this).attr('name') + "' id='" + $(this).attr('id') + "' field-type='" + $(this).attr('field-type') +
							"' class=\"" + $(this).attr('class') + "\">");
					}

					// adiciona as opções no seletor ENUM
					var options;
					for(i=0;i<result.length;i++) {
						var marca_selected = "";
						var marca_checked = "";
						if(result[i] == value_input) {
							marca_selected = "selected";
							marca_checked  = "checked";
						}

						if(result.length <= 5){
							novoelemento.append('<div class="input-radio-custom"><input type="radio" '+marca_checked+' name="' +
								$(this).attr('name') +'" value="'+ result[i] + '" id="'+ $(this).attr('name')+result[i] +'" field-type="radio"><span></span><label for="'
								+ $(this).attr('name')+result[i] +'">'+ result[i] +'</label><div class="div_input_radio"></div></div>');
						}else{
							novoelemento.append('<option value="' + result[i] +'" '+marca_selected+'>'+ result[i] +'</option>');
						}
					}

					// adiciona o seletor na div
					$(this).parent().append(novoelemento);

					// remove o input anterior
					$(this).remove();
				}
			}
		});

		// Modifica inputs checkbox no filtro de pesquisa
		if( $("#filtros .switch.small.round").length > 0 ) {
			$("#filtros .switch.small.round").each(function() {
				var anchor 				= $(this);
				var name_checkbox 		= anchor.find('input[type="hidden"]').attr('name');
				var value_checkbox 		= anchor.find('input[type="hidden"]').val();
				var checar_checkbox 	= anchor.find('input[type="checkbox"]').is(':checked');
				var value_filterinput 	= anchor.data('filterinput');
				anchor.html('');

				var marca_sim_checked 	= "";
				var marca_nao_checked 	= "";
				var marca_todos_checked = "";
				if(checar_checkbox) {
					marca_sim_checked = "checked";
				}else{
					if(value_checkbox == "0" && value_filterinput != "nullabled") {
						marca_nao_checked = "checked";
					}
				}
				if(marca_sim_checked == "" && marca_nao_checked == "") {
					marca_todos_checked = "checked";
				}

				var element_radios = (
					'<div class="input-radio-custom">' +
						'<input type="radio" '+marca_sim_checked+' name="'+name_checkbox+'" value="1" field-type="radio"><span></span> <div style="float:left;margin:6px;">SIM</div>' +
					'</div>' +
					'<div class="input-radio-custom">' +
						'<input type="radio" '+marca_nao_checked+' name="'+name_checkbox+'" value="0" field-type="radio"><span></span> <div style="float:left;margin:6px;">NÃO</div>' +
					'</div>' +
					'<div class="input-radio-custom">' +
						'<input type="radio" '+marca_todos_checked+' name="'+name_checkbox+'" value="" field-type="radio"><span></span> <div style="float:left;margin:6px;">TODOS</div>' +
					'</div>'
				);

				anchor.html(element_radios);
			});
		}

		// Filtro da listagem
		$('#filtros form').off().on('submit', function(event) {
			// Inicializa os parametros
			var param = "";
			
			$("#filtros form .input-form input, #filtros form .input-form select").each(function() {
				if($(this).attr('field-type') != undefined) {
					if ($(this).data('ac')) {
						// Armazena o nome do input do codigo
						var input = $(this).attr('rel');

						// Busca os valores
						var valor = $('#' + input).val(),
							nome  = $('#' + input).attr('name'),
							tipo  = $('#' + input).attr('field-type');

						if (valor != '' && valor != undefined) {
							// Adiciona o parametro do label
							param += '/' + nome + "_label/" + $(this).val();
						}
					} else {
						// Busca os valores
						var valor = $(this).val(),
							nome  = $(this).attr('name'),
							tipo  = $(this).attr('field-type');

						// // Verifica se é checkbox e se não está checado
						// if (tipo == "checkbox" && !$(this).is(':checked')) {
						// 	// Adiciona o parametro
						// 	valor = "";
						// }

						// Verifica se é radio
						if(tipo == "radio" && !$(this).is(':checked')) {
							// Limpa valor
							valor = "";
						}

						if (valor != '' && valor != undefined) {
							if(tipo == 'date' || tipo == 'datetime') {
								// Substitui a barra pelo hifen
								valor = valor.replace("/", "-").replace("/", "-");
							}

							// Adiciona o parametro
							param += '/' + nome + "/" + valor;
						}
					}
				}
			});

			// Envia o usuario para a busca
			window.location = $(this).attr('action') + param;
			return false;
		});

		// Limpar busca
		$('#filtros .input-reset-search').off().on('click', function(event) {
			// Envia o usuario para a busca
				window.location = $(this).data('url');
				return false;
		});
	}

	if( $('table.list tr.filter input[type="checkbox"]').length > 0 ) {
		$('table.list tr.filter input[type="checkbox"]').on('click', function(event) {
			// Inicializa os parametros
			var param = "";

			// Busca os valores
			var valor = $(this).is(':checked');
			var nome = $(this).attr('name');

			if(valor) {
				valor = 1;
			}
			else {
				valor = 0;
			}
		});
	}

	// No filtro no list, ao selecionar o datepicker já submita o form filter
	if( $("table.list tr.filter input.datepicker").length > 0 ) {
		$("table.list tr.filter input.datepicker").on('change', function() {
			// Inicializa os parametros
			var param = "";

			// Busca os valores
			var valor = $(this).val();
			var nome = $(this).attr('name');

			param += nome + "/" + valor.replace('/','-').replace('/','-');

			// Envia o usuario para a busca
			window.location = $(this).closest('tr.filter').data('search') + "/" + param;
		});
	}

	// Verifica o click da tabela detalhe
	if( $('.tab-table-list table tr td').length > 0 ) {
		$('.tab-table-list table tr td').on('click', function() {
			// Retorna a url
			var url = $(this).closest('tr').data('url');

			// Verifica se tem data-url
			if(url.length > 0) {
				window.location = url;
			}
		});
	}
}

/*
 * ------------------------------------------------------
 *  Funções dos formulários
 * ------------------------------------------------------
 */
function funcoesForm() {
	// Ativa fancybox
	$("a[href$='.jpg'],a[href$='.jpeg'],a[href$='.png'],a[href$='.gif']").not('.no-fancybox').attr('rel', 'gallery').fancybox();

	// Evento do botão cancelar
	if( $('div.form-buttons button').length > 0 ) {
		$('div.form-buttons button').on('click', function() {
			var string = $(this).data('url');
			if( string != '' && string != undefined ){
				position = string.indexOf('/' + $(this).data('primary') +  '/');
				if(position > 0) {
					var url = string.substring(0, position);
				}
				else {
					var url = string;
				}

				window.location = url;
			}
		});
	}

	// Adiciona o preview nos campos file
	if( $('.button.input-file-upload').length > 0 ) {
		$('.button.input-file-upload').each(function() {
			var elem = $(this),
				elemp = elem.parent(),
				vpreview = elem.data('preview'),
				vdelete = elem.data('delete')
			;
			if( vpreview != undefined && vpreview != '' ){
				extensao = (vpreview.substring(vpreview.lastIndexOf("."))).toLowerCase();
				// elemp.append('<div class="clearfix"></div>');
				if( ['.jpg', '.jpeg', '.png', '.gif'].indexOf(extensao) != -1 ) {
					elemp.append('<a href="' + document.basePath + '/' + vpreview + '" target="_blank" class="item-preview button medium left" alt="Visualizar"><i class="mdi mdi-eye"></i></a>');
					$("a[href$='.jpg'],a[href$='.jpeg'],a[href$='.png'],a[href$='.gif']").not('.no-fancybox').attr('rel', 'gallery').fancybox();
				}else{
					elemp.append('<a href="' + document.basePath + '/' + vpreview + '" target="_blank" class="item-preview button medium left" alt="Download"><i class="mdi mdi-download"></i></a>');
				}
			}

			if( vdelete != undefined && vdelete != '' ) {
				var urlDelete = '';

				// Verifica se tem o data-url do botão cancelar
				if( $('#cancel').prop('href') != undefined && $('#cancel').prop('href') != '' ) {
					var urlDelete = $('#cancel').prop('href').replace('/list','/deletefile');
				}else{
					// Captura a action do form de edição
					if($("#form_admin").length > 0) {
						if(!!$("#form_admin").attr("action")) {
							urlDelete = $("#form_admin").attr("action").replace('/form', '/deletefile');
						}
					}
				}

				// Insere o botão de excluir imagem
				if( urlDelete != undefined && urlDelete != "" ) {
					elemp.append('<a href="' + urlDelete + '' + vdelete + '" class="item-preview arquivo-delete button medium left" alt="Deletar"><i class="mdi mdi-delete"></i></a>');
				}
			}

			if(elem.find('input[type="file"]').prop('readonly')){
				if(vpreview != undefined && vpreview != ''){
					elem.remove();
				}else{
					elem.parent().html('-');
				}
			}
		});
	}

	if( $('.button.input-file-upload input[type="file"]').length > 0 ) {
		if (Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0) {
			$('.button.input-file-upload input[type="file"]').removeAttr("multiple");
		}

		$('.button.input-file-upload input[type="file"]').off().on('change', function() {
			var elem = $(this),
				elemp = elem.parent()
				elemspan = elemp.parent().find('span.nome-arquivo')
			;

			if( elemspan.length <= 0 ) {
				elemp.before('<span class="nome-arquivo"></span><div class="clearfix"></div>')					
				elemspan = elemp.parent().find('span.nome-arquivo');
			}

			if( elem.is('[multiple]') ) {
				files = elem.get(0).files;
				total = files.length;

				var names = [];
				$.each(files, function(i, e){
					names.push(e.name);
				})
				names = names.join(', ');

				if( total <= 0 ){
					elemspan.html( "Nenhum arquivo selecionado" );
				}else{
					if( total == 1){
						elemspan.html( total + " arquivo selecionado ("+ names +")" );
					}else{
						elemspan.html( total + " arquivos selecionados ("+ names +")" );
					}
				}
			}else{
				elemspan.html( elem.val() );
			}
		});
	}

	// Percorre os inputs e verifica qual possui um link do youtube
	$('input[type="text"]').each(function() {
		var valor_input = $(this).val();

		if(valor_input != "") {
			var videoid = valor_input.match(/(?:youtube(?:-nocookie)?\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/);
			if(videoid != null && videoid[1] != "") {
			    $(this).parent().append('<a href="https://www.youtube.com/watch?v='+videoid[1]+'" target="_blank" class="video-admin item-preview-video button medium left" alt="Visualizar"><i class="mdi mdi-video"></i></a>');
			} else { 
			    // sem vídeo
			}
		}
	});

	// Adiciona o preview nos campos vídeos
	$('.video-admin').on('click', function() {
		$.fancybox({
			'padding'			: 0,
			'autoScale'			: false,
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'title'				: this.title,
			'width'				: 640,
			'height'			: 385,
			'href'				: this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
			'type'				: 'swf',
			'swf'				: {
			'wmode'				: 'transparent',
			'allowfullscreen'	: 'true'
			}
		});

		return false;
	});

	// Mensagem de remover
	$('.arquivo-delete').on('click', function() {
		if(!confirm('Deseja remover o arquivo?')) {
			return false;
		}

		return true;
	});

	// Focus no primeiro input quando o formulário for vazio
	var formBotao = $('button[form=form_admin]').text().toLowerCase();
	var form_cadastrar = formBotao.indexOf('cadastrar') > -1;
	if(form_cadastrar) {
		var prim_input = $('#form_admin').find('input[type=text],textarea,select').filter(':visible:first');
		prim_input.focus();
	}
}

/*
 * ------------------------------------------------------
 *  Máscaras
 * ------------------------------------------------------
 */
window.initMascaras = function()
{
	if( $.fn.inputmask )
	{
		// Não mostra a mascara durante o hover
		Inputmask.prototype.defaults.showMaskOnHover = false;

		// Telefone
		var mascara_telefone = $('.mascara-telefone');
		if( mascara_telefone.length )
		{
			mascara_telefone.inputmask("(99) 9999-9999 [9]");
			mascara_telefone.on('focusout', function()
			{
				var elemento_at, element;

				element = $(this);

				var telefone = element.val().replace(/\D/g, "");

				if( telefone.length > 10 )
				{
					element.inputmask("(99) 99999-9999");
				} else
				{
					element.inputmask("(99) 9999-9999 [9]");
				}

			});

			mascara_telefone.trigger("focusout");
		}

		var mascara_phone = $('input[name="telefone"]');
		if( mascara_phone.length && !mascara_phone.closest('div.no-mask').length)
		{
			mascara_phone.inputmask("(99) 9999-9999 [9]");
			mascara_phone.on('focusout', function()
			{
				var elemento_at, element;

				element = $(this);

				var telefone = element.val().replace(/\D/g, "");

				if( telefone.length > 10 )
				{
					element.inputmask("(99) 99999-9999");
				} else
				{
					element.inputmask("(99) 9999-9999 [9]");
				}

			});

			mascara_phone.trigger("focusout");
		}

		// Telefone sem ddd
		var mascara_telefone_sem_ddd = $('.mascara-telefone-sem-ddd');
		if( mascara_telefone_sem_ddd.length )
		{
			mascara_telefone_sem_ddd.inputmask("9999-9999 [9]");
			mascara_telefone_sem_ddd.on('focusout', function()
			{
				var elemento_at, element;

				element = $(this);

				var telefone = element.val().replace(/\D/g, "");

				if( telefone.length > 8 )
				{
					element.inputmask("99999-9999");
				} else
				{
					element.inputmask("9999-9999 [9]");
				}

			});

			mascara_telefone_sem_ddd.trigger("focusout");
		}

		// DDD
		var mascara_ddd = $('.mascara-ddd');
		if( mascara_ddd.length )
		{
			mascara_ddd.inputmask("99");
		}

		// Data
		var mascara_data = $('.mascara-data');
		if( mascara_data.length )
		{
			mascara_data.inputmask("99/99/9999");
		}

		// Hora
		var mascara_hora = $('.mascara-hora');
		if( mascara_hora.length )
		{
			mascara_hora.inputmask("99:99");
		}

		// Cep
		var mascara_cep = $('.mascara-cep');
		if( mascara_cep.length )
		{
			mascara_cep.inputmask("99999-999");
		}

		// CPF
		var mascara_cpf = $('.mascara-cpf');
		if( mascara_cpf.length )
		{
			mascara_cpf.inputmask("999.999.999-99");
		}

		// CPNJ
		var mascara_cnpj = $('.mascara-cnpj');
		if( mascara_cnpj.length )
		{
			mascara_cnpj.inputmask("99.999.999/9999-99");
		}

		// CEI
		var mascara_cei = $('.mascara-cei');
		if( mascara_cei.length )
		{
			mascara_cei.inputmask("99.999.99999/99");
		}

		// RG
		var mascara_rg = $('.mascara-rg');
		if( mascara_rg.length )
		{
			mascara_rg.inputmask("99.999.999-9");
		}

		// Cep
		var mascara_cep = $('.mascara-cep');
		if( mascara_cep.length )
		{
			mascara_cep.inputmask("99999-999");
		}

		// Date
		var mascara_date = $('input').filter('[field-type="date"]');
		if( mascara_date.length > 0 ) {
			mascara_date.inputmask("99/99/9999");

			// Adiciona o datepiker
			mascara_date.datepicker();

			// No filtro no list, ao selecionar o datepicker já submita o form filter
			$("table.list tr.filter input.datepicker").on('change', function() {
				// Inicializa os parametros
				var param = "";

				// Busca os valores
				var valor = $(this).val();
				var nome = $(this).attr('name');

				param += nome + "/" + valor.replace('/','-').replace('/','-');

				// Envia o usuario para a busca
				window.location = $(this).closest('tr.filter').data('search') + "/" + param;
			});
		}

		// Datetime
		var mascara_datetime = $('input').filter('[field-type="datetime"]');
		if( mascara_datetime.length > 0 ) {
			mascara_datetime.inputmask("99/99/9999 99:99");

			// Adiciona o datepiker
			mascara_datetime.datetimepicker();

			// No filtro no list, ao selecionar o datetimepicker já submita o form filter
			$("table.list tr.filter input.datetimepicker").on('change', function() {
				// Inicializa os parametros
				var param = "";

				// Busca os valores
				var valor = $(this).val();
				var nome = $(this).attr('name');

				data = valor.split(" ");

				parametro = data[0].replace('/','-').replace('/','-') +" "+ data[1];

				param += nome + "/" + parametro;

				// Envia o usuario para a busca
				window.location = $(this).closest('tr.filter').data('search') + "/" + param;
			});
		}
	}
}