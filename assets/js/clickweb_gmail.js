// Helpers
import { ajaxGetError } from './helpers';

import {AJAX_LOGIN} from './api';

/**
 * Init
 */
export function init() {
	if( typeof window.google !== 'undefined' )
	{
		return false;
	}

	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if( d.getElementById(id) )
		{
			return;
		}
		js     = d.createElement(s);
		js.id  = id;
		js.src = "https://accounts.google.com/gsi/client";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'google-jssdk'));
}

init();

function initGoogle() {
	let googleTimeout;

	if( !window.google )
	{
		googleTimeout = setTimeout(() => {
			// Re-execute
			initGoogle();
		}, 500);

		return false;
	}

	clearTimeout( googleTimeout );

	window.google.accounts.id.initialize({
		client_id: '705344635051-e7fl7je81p3sccn2r8sgevgesc77pjsb.apps.googleusercontent.com',
		callback: (response) => {
			$("body").append('<div class="loading-box"><div class="loading-animacao"></div></div>');
			let retornar = $("#google-login-button").parent().data("retornar");
			$.ajax({
				url: AJAX_LOGIN,
				type: 'POST',
				contentType: "application/x-www-form-urlencoded;charset=utf-8",
				dataType: 'json',
				data: {
					access_token_google: response.credential,
					retornar: retornar
				}
			}).done(function (data) {
				if(!data) {
					Swal.fire("Ocorreu um erro!", "Ocorreu uma falha de comunicação com o servidor.", "error");
				} else if (data.status == "sucesso") {
					window.location.href = data.redirecionar_para;
				} else {
					Swal.fire(data.titulo ? data.titulo : "Ops!", data.mensagem, "error");
				}
			}).fail((jqXHR, textStatus, errorThrown) => {
				const error = ajaxGetError(jqXHR);

				if( textStatus !== 'abort' )
				{
					Swal.fire(error.error_title, error.error_message, error.error_icon);
				}
			}).always(function () {
				$("body").find('.loading-box').remove();
			});
		}
	});

	// Render button
	window.google.accounts.id.renderButton(
		document.getElementById("google-login-button"),
		{
			type : "icon",
			theme: "outline",
			size : "large",
			shape: "circle"
		}
	);
}

$(document).ready(() => {
	initGoogle();
});