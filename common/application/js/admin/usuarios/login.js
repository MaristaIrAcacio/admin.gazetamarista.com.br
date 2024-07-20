$(function() {
	// Cria o evento de recuperar a senha
	$('#submit').parent().find('a').on('click', function(e) {
		if($('#login').val() != "") {
			window.location = $(this).attr('href') + $('#login').val();
		}else{
			$('input#login').focus();
			swal('Ops!', 'Informe o Login para recuperar a senha', 'error');
		}
		
		e.preventDefault();
		return false;
	});
});