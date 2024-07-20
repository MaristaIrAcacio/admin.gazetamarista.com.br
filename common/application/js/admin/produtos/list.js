$(function() {
	// Botão rodar CRON
	var loadcron = $("<li><a class='button btn-view secondary loadcron' href='"+document.basePath+"/default/cron/disparo?page=1'><i class='mdi mdi-download'></i>Rodar CRON produtos</a></li>");
	
	// Add botão
	$(".buttons-bar .button-group").append(loadcron);

	// Click load cron
	$(document).on('click', '.loadcron', function (e) {
		e.preventDefault();
		$('#preloader').show();

		// Faz a requisição
		$.ajax({
			url: $(this).attr('href'),
			type: 'GET',
			success: function() {
				swal('Sucesso!', 'Atualização realizada com sucesso!', 'success');
				$('#preloader').remove();
				setTimeout(function() {window.location.reload(true)}, 1000);
			},
			error: function() {
				$('#preloader').remove();
				swal('Erro!', 'Ocorreu um erro, tente novamente!', 'error');
				return false;
			}
		});
	});
});
