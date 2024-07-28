$(function() {

	// Foco automático no campo de usuário
	$("#login").focus();


	// -------------------------------------------------------
	// Lógica de envio do formulário
	// -------------------------------------------------------

	var formulario = document.getElementById("form-login");

	formulario.addEventListener('submit', (event) => {
		event.preventDefault();

		var response = grecaptcha.getResponse();
		if (response.length === 0) {
			$(".error-message").removeClass('error-message-hidden');
			event.preventDefault();
		} else {
			$(".error-message").addClass('error-message-hidden');

			var user = $("#login").val();
			var senha = $("#senha").val();

			if (user.length > 0 && senha.length > 0) {
				formulario.submit();
			};

		};
		
	});
});