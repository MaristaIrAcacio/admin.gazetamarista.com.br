import {ajaxGetError} from "../helpers";

$(document).ready(() => {
	let $site_corpo = $('#site-corpo');

	if( $site_corpo.hasClass('main-noticias') )
	{
		$site_corpo.find('.form-search .btn-limpar').on('click', (e) => {
			const obj  = $(e.currentTarget);
			const form = obj.closest('form');

			form.find('input').val('');
			form.trigger("submit");
		});

		/*------------------------------------------------------
		*  Carregar mais posts
		*----------------------------------------------------- */

		// Ao clicar em carregar mais
		$(".load-more-posts").on("click", function(e) {
			let botao = $(this);
			let botao_html = botao.html();
			let caixa_carregar_listagem = $(".container-carregar-mais");
			let loading_svg   = '<svg class="btn-loading-svg" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="40px" height="40px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">' +
			'	<path opacity="0.4" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946' +
			'		s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634' +
			'		c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"/>' +
			'	<path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0' +
			'		C22.32,8.481,24.301,9.057,26.013,10.047z">' +
			'		<animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 20 20" to="360 20 20" dur="0.5s" repeatCount="indefinite"/>' +
			'	</path>' +
			'</svg>';

			// Desabilita o botão
			botao.prop('disabled', true).addClass('btn-loading').html(loading_svg + 'Carregando...').blur();

			$.ajax({
				url: botao.attr("data-link"),
				method: "POST",
				data: {
					page: botao.attr("data-page"),
				},
				dataType: "json",
				cache: false,
				timeout: 10000,
			})
			.always(function() {
				// Habilita o botão
				botao
				.prop("disabled", false)
				.removeClass("btn-loading")
				.html(botao_html);
			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				const error = ajaxGetError(jqXHR);
				if (textStatus !== "abort") {
					Swal.fire(
						error.error_title,
						error.error_message,
						error.error_icon
					);
				}
			})
			.done(function(data, textStatus, jqXHR) {
				if (data.status === "erro") {
					Swal.fire(data.titulo, data.mensagem, "error");
					return false;
				} else {
					// Se não tem mais itens para carregar, remove o botão
					if (data.ultima_pagina === 1) {
						// Remove o botão
						botao.remove();
					} else {
						// Atualiza o número da página no botão
						botao.attr("data-page", parseInt(botao.attr("data-page")) + 1);
					}
	
					let itens = "";
	
					for (let i = 0; i < data.itens.length; i++) {
						itens +=
						"<div class='uk-width-1-1 uk-width-1-2@s uk-width-1-3@m'>" +
						"    <div class='news-item'>" +
						"        <a href='" + data.itens[i].url + "'>" +
						"            <figure>" +
						"                <img data-src='" + data.itens[i].imagem.url + "' data-width='" + data.itens[i].imagem.width + "' data-height='" + data.itens[i].imagem.height + "' uk-img alt='" + data.itens[i].titulo + "'>" +
						"            </figure>" +
						"            <p class='date'>" + data.itens[i].data + "</p>" +
						"            <h3>" + data.itens[i].titulo + "</h3>" +
						"            <button class='uk-button uk-button-outline'>Ler notícia</button>" +	
						"        </a>" +
						"    </div>" +
						"</div>";
					}
	
					caixa_carregar_listagem.append(itens);
				}
			});
		});

		$("#formSearch").submit((event) => {
			
			// Impede que o formulário seja enviado
			event.preventDefault();
			
			// Verifica se existe alguma busca
			if ($("#buscaInput").val() !== '') {

				// Captura o valor digitado
				var busca = encodeURIComponent($("#buscaInput").val());
				var currentUrl = window.location.href;

				var baseUrl = currentUrl.replace(/\/1\/.*$/, '');

				window.location.href = baseUrl + '/1/' + busca;
			};
		});
		
		// Mostra o campo de busca
		$(".btn-busca").click(() => {
			if ($("#buscaInput").val() === '') {
				$("#buscaInput").toggleClass("hidden");
			};
			$("#buscaInput").focus();
		});

		// Fecha o campo quando não clicado nele
		$(document).click(function(event) {
			if (!$(event.target).closest('.btn-busca, #buscaInput').length) {
				if (!$("#buscaInput").hasClass("hidden") && $("#buscaInput").val() === '') {
					$("#buscaInput").addClass("hidden");
				}
			}
		});
	
		// Incializa o sistema de busca
		$("#buscaInput").click((event) =>event.stopPropagation());

	}
});
