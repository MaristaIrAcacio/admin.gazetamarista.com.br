import formValidation from '../vendor/formvalidation/core/Core';
import formValidationLocalePtBR from "../vendor/formvalidation/locales/pt_BR";
import formValidationDeclarative from "../vendor/formvalidation/plugins/Declarative";
import formValidationTrigger from "../vendor/formvalidation/plugins/Trigger";
import formValidationUikit from "../vendor/formvalidation/plugins/Uikit";
import formValidationSubmitButton from "../vendor/formvalidation/plugins/SubmitButton";
import formValidationFieldStatus from "../vendor/formvalidation/plugins/FieldStatus";
import {ajaxGetError} from "../helpers";
import formValidationRecaptcha from "../vendor/formvalidation/plugins/Recaptcha";

const recaptchaKey = _GLOBALS.recaptcha_key;

$(document).ready(() => {
    let $site_corpo = $('#site-corpo');

    if( $site_corpo.hasClass('contato') )
    {
        // Ao escolher assunto Envio de currículo, habilita o campo de upload
        $site_corpo.find('select[name="assunto"]').on('change', function () {
            let obj = $(this);

            $site_corpo.find('.curriculo').find('input[type="file"]').val('').change();
            if( obj.val() === 'Envio de currículo' ) {
                $site_corpo.find('.curriculo').removeClass('uk-hidden');
            } else {
                $site_corpo.find('.curriculo').addClass('uk-hidden');
            }
        });

        // Ao entrar na tela com o link de trabalhe conosco, já habilitar o select
        let searchParams = new URLSearchParams(window.location.search)
        if( searchParams.has('curriculo') ) {
            $('.assunto').val('Envio de currículo').trigger('change');
        }

        // Validação exclusica
        const form               = document.getElementById('form-contato');
        const submitAutoDisable  = !(form.getAttribute('data-validate-submit-status') === 'false');
        const submitButton       = form.getElementsByClassName('btn-enviar')[0];
        const recaptchaContainer = form.getElementsByClassName('recaptcha-container');

        form.fv = formValidation(
            form,
            {
                locale      : 'pt_BR',
                localization: formValidationLocalePtBR,
                plugins     : {
                    declarative : new formValidationDeclarative({
                        html5Input: true,
                    }),
                    trigger     : new formValidationTrigger({
                        event: 'blur change input',
                    }),
                    uikit       : new formValidationUikit(),
                    submitButton: new formValidationSubmitButton(),
                    //...(isAjax ? {
                    //...
                    //} : {
                    //	defaultSubmit: new formValidationDefaultSubmit(),
                    //}),
                    ...(recaptchaContainer.length ? {
                        recaptcha: new formValidationRecaptcha({
                            element: recaptchaContainer[0],
                            message: 'Segurança válida, clique acima para refazer',
                            siteKey: recaptchaKey,
                            size   : 'normal',
                            theme  : 'light',
                        }),
                    } : {}),
                    fieldStatus: new formValidationFieldStatus({
                        onStatusChanged: (areFieldsValid) => {
                            if( !submitAutoDisable || !submitButton ) return;

                            submitButton.disabled = !areFieldsValid;
                        }
                    }),
                },
            }
        ).on('core.form.valid', () => {
            let obj              = $(form);
            let button           = obj.find('.btn-enviar');
            let button_html      = button.html();
            let loading_text     = button.attr('data-loading-text');
            let disable_reset    = obj.is('[data-disable-reset]');
            let is_multipart     = obj.is('[enctype="multipart/form-data"]');
            let loading_svg      = '<svg class="btn-loading-svg" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="40px" height="40px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">' +
                '	<path opacity="0.4" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946' +
                '		s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634' +
                '		c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"/>' +
                '	<path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0' +
                '		C22.32,8.481,24.301,9.057,26.013,10.047z">' +
                '		<animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 20 20" to="360 20 20" dur="0.5s" repeatCount="indefinite"/>' +
                '	</path>' +
                '</svg>';

            // Disable button
            button.prop('disabled', true).addClass('btn-loading').html((loading_text ? loading_text : '') + loading_svg).blur();
            let dataAjax = {};
            if( is_multipart )
            {
                dataAjax = {
                    contentType: false,
                    processData: false,
                }
            }
            $.ajax({
                url     : obj.attr('action'),
                method  : obj.attr('method'),
                data    : is_multipart ? new FormData(form) : obj.serialize(),
                dataType: 'json',
                cache   : false,
                timeout : 15000,
                ...dataAjax,
            }).fail((jqXHR, textStatus) => {
                // Enable button
                button.prop('disabled', false).removeClass('btn-loading').html(button_html);

                const error = ajaxGetError(jqXHR);
                if( textStatus !== 'abort' )
                {
                    Swal.fire({
                        title    : error.error_title,
                        html     : error.error_message,
                        imageUrl : window._GLOBALS.basePath + '/common/default/images/geral/icon-error.png'
                    });
                }
            }).done((data) => {
                if( data.status === 'sucesso' )
                {
                    if( !disable_reset )
                    {
                        form.reset();
                    }

                    // Reset validation
                    form.fv.resetForm(true);

                    if( $.fn.animatedplaceholder )
                    {
                        // Atualiza os inputs para o animated placeholder
                        obj.find('input, select, textarea').trigger('change.animatedplaceholder_change');
                    }

                    if( 'redirecionar_para' in data )
                    {
                        if( 'alerta_antes_redirecionar' in data && data.alerta_antes_redirecionar === true )
                        {
                            Swal.fire({
                                title            : data.titulo,
                                html             : data.mensagem,
                                confirmButtonText: data.alerta_botao,
                                imageUrl         : window._GLOBALS.basePath + '/common/default/images/geral/icon-success.png'
                            }).then((result) => {
                                // Redirect
                                window.location = data.redirecionar_para;
                            });
                        }
                        else
                        {
                            // Redirect
                            window.location = data.redirecionar_para;
                        }
                    }
                    else if( 'atualizar_pagina' in data && data.atualizar_pagina === true )
                    {
                        // Enable button
                        button.prop('disabled', false).removeClass('btn-loading').html(button_html);

                        if( 'alerta_antes_atualizar_pagina' in data && data.alerta_antes_atualizar_pagina === true )
                        {
                            Swal.fire({
                                title            : data.titulo,
                                html             : data.mensagem,
                                confirmButtonText: data.alerta_botao,
                                imageUrl         : window._GLOBALS.basePath + '/common/default/images/geral/icon-success.png'
                            }).then((result) => {
                                // Refresh page
                                window.location.reload(true);
                            });
                        }
                        else
                        {
                            // Refresh page
                            window.location.reload(true);
                        }
                    }
                    else
                    {
                        $.fancybox.close();

                        // Enable button
                        button.prop('disabled', false).removeClass('btn-loading').html(button_html);

                        Swal.fire({
                            title    : data.titulo,
                            html     : data.mensagem,
                            imageUrl : window._GLOBALS.basePath + '/common/default/images/geral/icon-success.png'
                        });
                    }
                }
                else
                {
                    $.fancybox.close();

                    // Habilita o botão
                    button.prop('disabled', false).removeClass('btn-loading').html(button_html);
                    Swal.fire({
                        title   : data.titulo,
                        html    : data.mensagem,
                        imageUrl: window._GLOBALS.basePath + '/common/default/images/geral/icon-error.png'
                    });
                }
            });
        });

        const archiveValidators = {
            validators: {
                notEmpty: {
                    message: 'Campo obrigatório'
                }
            }
        };

        let add = 0;
        $site_corpo.find('#form-contato select[name="assunto"]').on('change', function () {
            if ($(this).val() === "Envio de currículo") {
                add = 1;
                // add field to valid list
                form.fv.addField('arquivo', archiveValidators);
            } else {
                // remove field from valid list
                if (add === 1) {
                    form.fv.removeField('arquivo', archiveValidators);
                }
            }
        });
    }
});