$(function() {
	// Seleciona os dados do input 'antes'
	var num_linhas_antes = 1;
	var input_campo_antes = $('#json_data_antes').val();
	if(input_campo_antes != "" && input_campo_antes != 'null') {
		var antes_json_parse  = $.parseJSON(input_campo_antes);
		var output_antes 	  = "";

		// Percorre os dados
		$.each(antes_json_parse, function( key, value ) {
			output_antes += key + ': ' + value + '\n';
		});

		// Atualiza o textarea
		$('#json_data_antes').val(output_antes);

		// // Conta quantas linhas existe no textarea antes
		var linhas_antes 		= output_antes.split('\n');
		var arr_linhas_antes 	= linhas_antes.filter(function(e){ return e.replace(/(\r\n|\n|\r)/gm,"")});
		num_linhas_antes 		= arr_linhas_antes.length;
	}

	// Seleciona os dados do input 'depois'
	var num_linhas_depois = 1;
	var input_campo = $('#json_data').val();
	if(input_campo != "" && input_campo != 'null') {
		var json_parse  	= $.parseJSON(input_campo);
		var output_depois 	= "";

		// Percorre os dados
		$.each(json_parse, function( key, value ) {
			output_depois += key + ': ' + value + '\n';
		});

		// Atualiza o textarea
		$('#json_data').val(output_depois);

		// Conta quantas linhas existe no textarea depois
		var linhas_depois 		= output_depois.split('\n');
		var arr_linhas_depois 	= linhas_depois.filter(function(e){ return e.replace(/(\r\n|\n|\r)/gm,"")});
		num_linhas_depois 		= arr_linhas_depois.length;
	}
	
	// Verifica altura do textarea
	var altura_antes = num_linhas_antes * 25;
	var altura_depois = num_linhas_depois * 25;

	if(altura_antes < 150) {
		altura_antes = 150;
	}

	if(altura_antes > 400) {
		altura_antes = 400;
	}

	if(altura_depois < 150) {
		altura_depois = 150;
	}

	if(altura_depois > 400) {
		altura_depois = 400;
	}

	// Campo texto
	$('#json_data_antes').css({'height':altura_antes+'px'});

	$('#json_data_antes').on('focus', function() {
		$(this).animate({
			height: '1000px'
		}, 400);
	});

	$('#json_data_antes').on('focusout', function() {
		$(this).animate({
			height: altura_antes+'px'
		}, 200);
	});

	// Campo texto
	$('#json_data').css({'height':altura_depois+'px'});

	$('#json_data').on('focus', function() {
		$(this).animate({
			height: '1000px'
		}, 400);
	});

	$('#json_data').on('focusout', function() {
		$(this).animate({
			height: altura_depois+'px'
		}, 200);
	});
});