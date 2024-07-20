// Helpers
import { ajaxGetError } from './helpers';

import {AJAX_LOGIN} from './api';

/**
 * Init
 *
 * @param appId
 * @param apiVersion
 * @param language
 */
export function init(appId = '757168562747818', apiVersion = 'v17.0', language = 'pt_BR') {
	if( typeof window.FB !== 'undefined' )
	{
		return false;
	}

	window.fbAsyncInit = () => {
		window.FB.init({
			appId  : appId,
			cookie : true,
			xfbml  : true,
			version: apiVersion,
		});
	};

	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if( d.getElementById(id) )
		{
			return;
		}
		js     = d.createElement(s);
		js.id  = id;
		js.src = "https://connect.facebook.net/" + language + "/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
}

init();

function initFacebook(retornar) {
	let facebookTimeout;

	if( !window.FB )
	{
		facebookTimeout = setTimeout(() => {
			// Re-execute
			initFacebook();
		}, 500);

		return false;
	}

	clearTimeout( facebookTimeout );

    window.FB.login((response) => {
        if( !response.authResponse )
        {
			$("body").find('.loading-box').remove();
            Swal.fire("Ops!", "Não foi possível fazer login via facebook, tente novamente.", "error");

            return false;
        }

        $.ajax({
            url: AJAX_LOGIN,
            type: 'POST',
            contentType: "application/x-www-form-urlencoded;charset=utf-8",
            dataType: 'json',
            data: {
                access_token_facebook: response.authResponse.accessToken,
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
    }, {
        auth_type: 'rerequest',
        scope    : 'email',
    });
}

$('.btn-facebook').on('click', function () {
	$("body").append('<div class="loading-box"><div class="loading-animacao"></div></div>');
    var retornar = $(this).data('retornar');
    initFacebook(retornar);
});
