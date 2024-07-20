$.fn.center = function () {
	this.css("position","absolute");
	this.css("top", (($(window).height() - this.outerHeight()) / 2) + $(window).scrollTop() + "px");
	this.css("left", (($(window).width() - this.outerWidth()) / 2) + $(window).scrollLeft() + "px");
	return this;
}

// Box de mensagem
$.msgBox = function(config) {
	$('#msg-box').fadeOut(500, function() {
		$(this).remove();
	});

	var div = $('<div id="msg-box"></div>')
		.addClass("msg-" + config.type)
		.html(config.message);
	$('body').append(div);

	var position = (($(window).width() - div.outerWidth()) / 2) + $(window).scrollLeft() + "px";

	div.css("left", position);
}


// Quando Clicar no icone de informação que aparece acima do campo, abre o SWAL.
$('.labeldiv .show_input_information').on('click', function(e) {
	let mensagem = $(this).attr('data-msg');

	swal({
		text: mensagem,
		button: "Entendi!",
		icon: "info",
	});
});



// Mostra os box de mensagem
if($('#msg-box').length > 0){
	$('#msg-box').fadeIn(500);
	setTimeout(function() {
		$('#msg-box').fadeOut(500, function() {
			$(this).remove();
		});
	}, 6000);
}

// Identificar tamanho da tela
var tela_largura = window.innerWidth;
var tela_altura = window.innerHeight;

var tamanho_largura = tela_largura-100;
if(tamanho_largura > 700) {
	tamanho_largura = 700;
}

var tamanho_altura = tela_altura-220;
if(tamanho_altura > 700) {
	tamanho_altura = 700;
}

//CKEditor, exibe se possuir o atributo data-ckeditor no campo texto
$( 'textarea[data-ckeditor]' ).ckeditor({
	height: tamanho_altura/2,
	width: tamanho_largura
});

$( 'textarea[data-ckeditor-big]' ).ckeditor({
	height: tamanho_altura,
	width: tamanho_largura
});

//CKEditor basic, exibe se possuir o atributo data-editor no campo texto
$( 'textarea[data-editor]' ).ckeditor({
	toolbar_Basic: [[ 'Bold', 'Italic', 'Underline', 'Strike', '-', 'TextColor', 'BGColor', '-', 'Styles', 'Format', 'Image' ]],
	toolbar: 'Basic',
	uiColor: '#666666',
	height: (tamanho_altura-300)/2,
	width: tamanho_largura
});

$( 'textarea[data-editor-big]' ).ckeditor({
	toolbar_Basic: [[ 'Bold', 'Italic', 'Underline', 'Strike', '-', 'TextColor', 'BGColor', '-', 'Styles', 'Format', 'Image' ]],
	toolbar: 'Basic',
	uiColor: '#666666',
	height: tamanho_altura-300,
	width: tamanho_largura
});

// Antes de enviar para o banco remove a '#'
$('#form_admin').submit(function() {
	$('input[data-colorpicker]').each(function(item,key) {
		if($(this).val().indexOf('#') == -1) {
		 	if(!(/^[0-9A-F]{3,6}$/i.test($(this).val()))) {
				$(this).val('000');
				$(this).css('border-color', '#'+$(this).val());
		  	}
			$(this).val($(this).val());
		}
	});
});

// Ajusta campos de ordenação para o type number
$input_ordem = $('#form_admin input[name="ordenacao"], #form_admin input[name="ordem"]');
$input_ordem.attr('type', 'number').attr('min', '1');
$input_ordem.val() > 0 ? '' : $input_ordem.val(1);

// Seta as Cores de todos os elementos com o elemento data-colorpicker.
$('input[data-colorpicker]').each(function(item,key) {
	var cor_val = $(this).val();

	$(this).val( cor_val.replace('#','') );
	$(this).attr('maxlength', '6');
	$(this).css('border-right', '40px solid');
 	$(this).css('border-color','#'+ $(this).val());
 	$(this).css('box-shadow', 'rgb(150, 150, 150) 0px 0px 5px');
 	$(this).css('-moz-box-shadow:', 'rgb(150, 150, 150) 0px 0px 5px');
 	$(this).css('-webkit-box-shadow', 'rgb(150, 150, 150) 0px 0px 5px');

 	if(!(/^[0-9A-F]{3,6}$/i.test(cor_val))) {
		$(this).val('000000');
		$(this).css('border-color', '#'+$(this).val());
	}

	// Cria a div que chama o colorpicker. 
	$(this).before($("<div class='colorpicker-div'></div>"));

	// Cria um colorPiker para cada input da iteração. 
	$(this).parent().find('.colorpicker-div').ColorPicker({
		color: '#'+ cor_val,
		onShow: function (colpkr) {
			console.log(cor_val);
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onSubmit: function(hsb, hex, rgb, el) {
			var input = $(el).parent().find('input');
			input.val(hex);
			input.css('border-color', '#'+hex);
			$(el).ColorPickerHide();
		},
		onChange: function (hsb, hex, rgb) {}
	});


	// Troca a cor do border do input quando digita uma cor.
	$(this).on('keyup', function() {
		$(this).css('border-color', '#'+$(this).val());
	});

	// Seta a cor preta quando o valor digitado não corresponde a nenhuma cor válida.
	$(this).on('blur', function(){
		if(!(/^[0-9A-F]{3,6}$/i.test($(this).val()))){
			$(this).val('000000');
			$(this).css('border-color', '#'+$(this).val());
		}
	});
	
	$(this).keypress(function(e) {
		if(e.which == 13) {
			if(!(/^[0-9A-F]{3,6}$/i.test($(this).val()))){
				$(this).val('000000');
				$(this).css('border-color', '#'+$(this).val());
			}
		}
	});
});

// Ajusta inputs integer somente números
$('#form_admin input.int.integer').keyup(function() {
  $(this).val(this.value.replace(/\D/g, ''));
});

// Ajusta máscara nos campos do tipo decimal float
$('#form_admin input.decimal.float').each(function() {
	$(this).priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });
});

// Adiciona o elemento <hr>
$("div.in-hr").after("<hr>");

// Bloqueia todos os inputs e selects do view.tpl
setTimeout(function() {
	// layouts -> view.tpl (view automatico)
	$('#div_all_view :input').prop("readonly", true);
	$('#div_all_view select option:not(:selected)').prop('disabled', true);
	$('#div_all_view select').css({'background-color':'#DDD'});
	$('#div_all_view input[type="checkbox"]').prop("disabled", true).css({'background-color':'#DDD'});
	$('#div_all_view input[type="radio"]:not(:checked)').prop("disabled", true).next().next().css({'color':'#BBB'});

	// view.tpl (view manual)
	$('.pagina-view select').prop("disabled", true);
	$('.pagina-view input[type="checkbox"]').prop("disabled", true).css({'background-color':'#DDD'});
	$('.pagina-view input[type="radio"]:not(:checked)').prop("disabled", true).next().next().css({'color':'#BBB'});
	$('.pagina-view .listcheckbox label').css({'background-color':'#DDD'});
	if($('.pagina-view .datepicker').length > 0) {
		$('.pagina-view .datepicker').datepicker("destroy");
	}
	if($('.pagina-view .datetimepicker').length > 0) {
		$('.pagina-view .datetimepicker').datepicker("destroy");
	}

	// Remove bloqueios de inputs no form de filtro
	$('div#filtros :input').prop("readonly", false);

	// Campos readonly com fundo cinza
	$('input[readonly], textarea[readonly]').css({'background-color':'#DDD'});
}, 800);
