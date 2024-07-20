// jQuery
window.$ = window.jQuery = require("jquery");

// UIkit
import UIkit from "uikit";

// Form Validation
import formValidation from "./vendor/formvalidation/core/Core";
import formValidationDeclarative from "./vendor/formvalidation/plugins/Declarative";
import formValidationDefaultSubmit from "./vendor/formvalidation/plugins/DefaultSubmit";
import formValidationFieldStatus from "./vendor/formvalidation/plugins/FieldStatus";
import formValidationIcon from "./vendor/formvalidation/plugins/Icon";
import formValidationLocalePtBR from "./vendor/formvalidation/locales/pt_BR";
import formValidationSubmitButton from "./vendor/formvalidation/plugins/SubmitButton";
import formValidationRecaptcha from "./vendor/formvalidation/plugins/Recaptcha";
import formValidationTrigger from "./vendor/formvalidation/plugins/Trigger";
import formValidationUikit from "./vendor/formvalidation/plugins/Uikit";

// Input mask
import Inputmask from "inputmask/dist/jquery.inputmask";

// Swal
window.Swal = require("sweetalert2/dist/sweetalert2");

// Fancybox
require("@fancyapps/fancybox/dist/jquery.fancybox");

// Swiper
import Swiper, {
	Autoplay,
	EffectFade,
	Navigation,
	Pagination,
	Scrollbar,
	Lazy,
	Grid,
} from "swiper";

// Configure Swiper to use modules
Swiper.use([
	Autoplay,
	EffectFade,
	Navigation,
	Pagination,
	Scrollbar,
	Lazy,
	Grid,
]);

// Animated placeholder
require('./vendor/animated-placeholder/animated-placeholder');

// Select2
require("select2/dist/js/select2.full");
require("select2/dist/js/i18n/pt-BR");

// MmenuLight
require("mmenu-light");

// Waypoint
require("./vendor/waypoints/waypoints");

// Helpers
import { ajaxGetError } from "./helpers";

// API
import {
	AJAX_REMOVER_FOTO,
	AJAX_CIDADES,
	AJAX_AUTOCOMPLETE_PRODUTOS,
} from "./api";

// Import pages
require("./pages/index");
require("./pages/noticias");
require("./pages/noticia-detalhe");
require("./pages/contato");
require("./pages/sobre-nos");

// Facebook login
require("./gazetamarista_facebook");

// Gmail login
// require("./gazetamarista_gmail");

const recaptchaKey = _GLOBALS.recaptcha_key;

// fancybox-active compensate-for-scrollbar

window.is_mobile = window.matchMedia('(max-width: 767px)').matches;

(window.matchMedia('(max-width: 767px)')).addEventListener('change', (e) => {
	window.is_mobile = e.matches;
});

const formatter = new Intl.NumberFormat('pt-BR', {
	style   : 'currency',
	currency: 'BRL',
});

$(document).ready(() => {
	/*------------------------------------------------------
	 *  Helpers
	 * ----------------------------------------------------- */
	window.is_touch_device =
		"ontouchstart" in window ||
		navigator.MaxTouchPoints > 0 ||
		navigator.msMaxTouchPoints > 0;

	$("html").addClass(window.is_touch_device ? "touch" : "no-touch");

	/*------------------------------------------------------
	 *  Form validation
	 * ----------------------------------------------------- */
	/**
	 * @param parent - jQuery el
	 */
	window.initValidacao = (parent) => {
		// Default element
		const $parent = parent ? parent : $("body");

		$parent.find("form[data-validate]").each((i, el) => {
			// Already loaded
			if (el.getAttribute("data-validate-loaded")) {
				return;
			}

			// Loaded
			el.setAttribute("data-validate-loaded", true);

			const hookOnComplete = el.getAttribute("data-onComplete");
			const hookOnFormInvalid = el.getAttribute("data-onFormInvalid");
			const hookOnFormReset = el.getAttribute("data-onFormReset");
			const disableSuccessModal = $(el).is("[data-disable-success-modal]");
			const isAjax = el.getAttribute("data-validate") === "ajax";
			const isLiveValidate = $(el).is("[data-livevalidate]");
			const submitAutoDisable = !(
				el.getAttribute("data-validate-submit-status") === "false"
			);
			const submitButton = el.getElementsByClassName("btn-enviar")[0];
			const recaptchaContainer = el.getElementsByClassName(
				"recaptcha-container"
			);

			// Load validation
			el.fv = formValidation(el, {
				locale: "pt_BR",
				localization: formValidationLocalePtBR,
				plugins: {
					declarative: new formValidationDeclarative({
						html5Input: true,
					}),
					trigger: new formValidationTrigger({
						event: `blur change input${isLiveValidate ? " keyup" : ""}`,
					}),
					uikit: new formValidationUikit(),
					submitButton: new formValidationSubmitButton(),
					//...(isAjax ? {
					//...
					//} : {
					//	defaultSubmit: new formValidationDefaultSubmit(),
					//}),
					...(recaptchaContainer.length
						? {
								recaptcha: new formValidationRecaptcha({
									element: recaptchaContainer[0],
									message: "Segurança inválida, clique acima para refazer",
									siteKey: recaptchaKey,
									size: "normal",
									theme: "light",
								}),
						  }
						: {}),
					fieldStatus: new formValidationFieldStatus({
						onStatusChanged: (areFieldsValid) => {
							if (!submitAutoDisable || !submitButton) return;

							submitButton.disabled = !areFieldsValid;
						},
					}),
				},
			}).on("core.form.valid", () => {
				let obj = $(el);
				let button = obj.find(".btn-enviar");
				let button_html = button.html();
				let loading_text = button.attr("data-loading-text");
				let disable_reset = obj.is("[data-disable-reset]");
				let disable_loading_inline = obj.is("[data-disable-loading-inline]");
				let is_multipart = obj.is('[enctype="multipart/form-data"]');
				let loading_svg =
					'<svg class="btn-loading-svg" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="40px" height="40px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">' +
					'	<path opacity="0.4" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946' +
					"		s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634" +
					'		c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"/>' +
					'	<path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0' +
					'		C22.32,8.481,24.301,9.057,26.013,10.047z">' +
					'		<animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 20 20" to="360 20 20" dur="0.5s" repeatCount="indefinite"/>' +
					"	</path>" +
					"</svg>";

				
				// Disable button
				button
					.prop("disabled", true)
					.addClass("btn-loading")
					.html((!disable_loading_inline ? loading_svg : button_html) + (loading_text ? loading_text : ""))
					.blur();

				if(disable_loading_inline) {
					obj.parent().append('<div class="loading-box"><div class="loading-animacao"></div></div>');
				}

				if (!isAjax) {
					el.submit();

					return;
				}

				let dataAjax = {};

				if (is_multipart) {
					dataAjax = {
						contentType: false,
						processData: false,
					};
				}

				$.ajax({
					url: obj.attr("action"),
					method: obj.attr("method"),
					data: is_multipart ? new FormData(el) : obj.serialize(),
					dataType: "json",
					cache: false,
					timeout: 35000,
					...dataAjax,
				})
					.always(() => {
						if(disable_loading_inline) {
							obj.parent().find(".loading-box").remove();
						}
					})
					.fail((jqXHR, textStatus, errorThrown) => {
						// Enable button
						button
							.prop("disabled", false)
							.removeClass("btn-loading")
							.html(button_html);

						const error = ajaxGetError(jqXHR);

						if (textStatus !== "abort") {
							Swal.fire(
								error.error_title,
								error.error_message,
								error.error_icon
							);
						}

						if(hookOnComplete && typeof window[hookOnComplete] === "function") {
							window[hookOnComplete]({data, el, status: "erro", error, jqXHR, textStatus, errorThrown});
						}
					})
					.done((data, textStatus, jqXHR) => {
						if(hookOnComplete && typeof window[hookOnComplete] === "function") {
							window[hookOnComplete]({data, el, status: data.status, jqXHR, textStatus});
						}

						if (data.status === "sucesso") {
							if (!disable_reset) {
								el.reset();
							}

							// Reset validation
							el.fv.resetForm(true);

							if ($.fn.animatedplaceholder) {
								// Atualiza os inputs para o animated placeholder
								obj
									.find("input, select, textarea")
									.trigger("change.animatedplaceholder_change");
							}

							if ("redirecionar_para" in data) {
								if (
									"alerta_antes_redirecionar" in data &&
									data.alerta_antes_redirecionar === true
								) {
									Swal.fire({
										icon: "success",
										title: data.titulo,
										html: data.mensagem,
										confirmButtonText: data.alerta_botao,
									}).then((result) => {
										// Redirect
										window.location = data.redirecionar_para;
									});
								} else {
									// Redirect
									window.location = data.redirecionar_para;
								}
							} else if (
								"atualizar_pagina" in data &&
								data.atualizar_pagina === true
							) {
								// Enable button
								button
									.prop("disabled", false)
									.removeClass("btn-loading")
									.html(button_html);

								if (
									"alerta_antes_atualizar_pagina" in data &&
									data.alerta_antes_atualizar_pagina === true
								) {
									Swal.fire({
										icon: "success",
										title: data.titulo,
										html: data.mensagem,
										confirmButtonText: data.alerta_botao,
									}).then((result) => {
										// Refresh page
										window.location.reload(true);
									});
								} else {
									// Refresh page
									window.location.reload(true);
								}
							} else {
								// Enable button
								button
									.prop("disabled", false)
									.removeClass("btn-loading")
									.html(button_html);

								// Adicionar produto ao carrinho
								if ($(el).hasClass("form-adicionar-carrinho")) {
									$(".product-quantity .uk-input").val(1);
									$("input[name='limparcarrinho']").remove();
									Swal.fire(data.titulo, data.mensagem, "success");
								} else if ($(el).hasClass("form-remover-carrinho")) {
									$(el).parents(".cart-item").fadeOut(400);
									setTimeout(() => {
										if($(".cart-item").length == 1) {
											$(".cart-empty").fadeIn(400);
											$(".btn-payment").prop("disabled", true);
										}
										$(el).parents(".cart-item").remove();
									}, 400);
								} else if ($(el).hasClass("form-consultar-frete")) {
									if( data.itens.length )
									{
										let listagemHtml = '';

										for( let i = 0; i < data.itens.length; i++ )
										{
											listagemHtml +=
											"<div class='shipping-item'>" +
											"	<p>" + data.itens[i].nome + "</p>" +
											"	<div class='right-container'>" +
											"		<span>" + data.itens[i].prazo + "</span>" +
											"		<p>" + data.itens[i].preco + "</p>" +
											"	</div>" +
											"</div>";
										}

										$(".shipping-list").html(listagemHtml);
									}
								} else if($(el).hasClass('form-remover-endereco')) {
									let idendereco = $(el).find('input[name="idendereco"]').attr("value");
									let endereco = $(".address-item[data-idendereco='" + idendereco + "']");
									
									UIkit.modal('#modal-remover-endereco').hide();
									
									if($(".address-item").length > 1) {
										endereco.slideUp(400, function() {
											$(this).remove();
										});
									} else {
										$(".address-list").slideUp(200);
										setTimeout(function() {
											$(".address-list").remove();
											$(".address-empty").slideDown(200);
										}, 200);
									}
								} else if(!disableSuccessModal) {
									console.log(disableSuccessModal)
									Swal.fire(data.titulo, data.mensagem, "success");
								}
							}
						} else if (data.status === "warning") {
							// Habilita o botão
							button
								.prop("disabled", false)
								.removeClass("btn-loading")
								.html(button_html);

							Swal.fire(data.titulo, data.mensagem, "warning");
						} else if (data.status === "info") {
							// Habilita o botão
							button
								.prop("disabled", false)
								.removeClass("btn-loading")
								.html(button_html);

							Swal.fire(data.titulo, data.mensagem, "info");
						} else {
							// Habilita o botão
							button
								.prop("disabled", false)
								.removeClass("btn-loading")
								.html(button_html);

							if($(el).hasClass("form-adicionar-carrinho") && data.limparcarrinho) {
								Swal.fire({
									icon: "error",
									title: data.titulo,
									html: data.mensagem,
									showCancelButton: true,
									cancelButtonText: "Cancelar",
									confirmButtonText: "Limpar carrinho",
									reverseButtons: true,
								}).then((result) => {
									if (result.isConfirmed) {
										$(el).append('<input type="hidden" name="limparcarrinho" value="1">');
										UIkit.notification({
											message: "Seu carrinho foi limpo e o produto adicionado com sucesso.",
											status: "success",
											pos: "top-right",
											timeout: 5000,
										});
										setTimeout(() => {
											$(".form-adicionar-carrinho .btn-enviar").trigger("click");
										}, 50);
									}
								});
							} else {
								Swal.fire(data.titulo, data.mensagem, "error");
							}
						}
					});
			}).on("core.form.invalid", (e) => {
				if(hookOnFormInvalid && typeof window[hookOnFormInvalid] === "function") {
					window[hookOnFormInvalid]({e, el});
				}
			}).on("core.form.reset", (e) => {
				if(hookOnFormReset && typeof window[hookOnFormReset] === "function") {
					window[hookOnFormReset]({e, el});
				}
			});
		});
	};

	// Inicia as validações
	initValidacao();

	/*------------------------------------------------------
	 *  Máscaras
	 * ----------------------------------------------------- */
	/**
	 * @param parent - Caso queira aplicar aos filhos de um elemento do jQuery
	 */
	window.initMascaras = (parent) => {
		// Default config
		Inputmask.prototype.defaults.showMaskOnHover = false;
		Inputmask.prototype.defaults.clearIncomplete = true;

		// Default element
		const $parent = parent ? parent : $("body");

		// Inline mask
		$parent.find("input[data-inputmask]").inputmask();

		// Phone
		const mask_phone = $parent.find(".mascara-telefone");

		if (mask_phone.length) {
			mask_phone.inputmask({ mask: ["(99) 9999-9999", "(99) 99999-9999"] });
		}

		// Date
		const mask_date = $parent.find(".mascara-data");

		if (mask_date.length) {
			mask_date.inputmask("99/99/9999");
		}

		// Time
		const mask_time = $parent.find(".mascara-hora");

		if (mask_time.length) {
			mask_time.inputmask("99:99");
		}

		// Zipcode
		const mask_zipcode = $parent.find(".mascara-cep");

		if (mask_zipcode.length) {
			mask_zipcode.inputmask("99999-999");
		}

		// RG
		const mask_rg = $parent.find(".mascara-rg");

		if (mask_rg.length) {
			mask_rg.inputmask({ mask: ["99.999", "99.999.999-9"] });
		}

		// CPF/CNPJ
		const mask_cpf_cnpj = $parent.find(".mascara-cpf-cnpj");

		if (mask_cpf_cnpj.length) {
			mask_cpf_cnpj.inputmask({
				mask: ["999.999.999-99", "99.999.999/9999-99"],
			});
		}

		// CPF
		const mask_cpf = $parent.find(".mascara-cpf");

		if (mask_cpf.length) {
			mask_cpf.inputmask("999.999.999-99");
		}

		// CPNJ
		const mask_cnpj = $parent.find(".mascara-cnpj");

		if (mask_cnpj.length) {
			mask_cnpj.inputmask("99.999.999/9999-99");
		}

		// Card
		const mask_card = $parent.find(".mascara-cartao");

		if (mask_card.length) {
			mask_card.inputmask({
				mask: ["9999 999999 99999", "9999 9999 9999 9999"],
			});
		}

		// Card expire date
		const mask_card_expire = $parent.find(".mascara-cartao-vencimento");

		if (mask_card_expire.length) {
			mask_card_expire.inputmask("99/99");
		}

		// Card code
		const mask_card_code = $parent.find(".mascara-cartao-codigo");

		if (mask_card_code.length) {
			mask_card_code.inputmask({ mask: ["999", "9999"] });
		}

		// Number
		const mask_number = $parent.find(".mascara-numero");

		if (mask_number.length) {
			mask_number.inputmask("integer", {
				placeholder: "",
				min: 0,
				rightAlign: false,
			});
		}

		// Money
		const mask_money = $parent.find(".mascara-dinheiro");

		if (mask_money.length) {
			mask_money.inputmask("currency", {
				prefix: "",
				groupSeparator: ".",
				radixPoint: ",",
				rightAlign: false,
			});

			// Clean mask on init
			mask_money.each((i, el) => {
				const obj = $(el);
				const val = obj.val();

				if (val === "") {
					obj.val("");
				}
			});
		}

		// Percentage
		const mask_percentage = $parent.find(".mascara-porcentagem");

		if (mask_percentage.length) {
			mask_percentage.inputmask("percentage", {
				rightAlign: false,
				suffix: " %",
			});
		}

		// Listagem mascara de numero nos filtros
		const mask_number_filters = $parent.find(".mascara-numero-filtos");

		if (mask_number_filters.length) {
			mask_number_filters.inputmask("numeric", {
				radixPoint: ".",
				rightAlign: false,
				allowMinus: true,
				placeholder: '',
				digitsOptional: true,
				// Fix botão de negativo no numpad
				shortcuts: "",
			});
		}
	};

	// Inicia as mascaras
	initMascaras();

	/*------------------------------------------------------
	 *  Animated Placeholder
	 * ----------------------------------------------------- */
	window.initPlaceholder = (parent) => {
		if (!$.fn.animatedplaceholder) {
			return false;
		}

		// Se não definiu um elemento usa o body
		let $parent = parent ? parent : $("body");

		$parent.find("[data-placeholder]").animatedplaceholder({
			label_top: "24px",
			label_left: "21px",
			label_focus_top: "12.5px",
			label_focus_left: "21px",
			label_focus_size: 0.857,
		});
	};

	// Inicia as validações de form ajax
	initPlaceholder();

	/*------------------------------------------------------
	 *  Input counter
	 * ----------------------------------------------------- */
	window.initInputContador = (parent) => {
		// Se não definiu um elemento usa o body
		let $parent = parent ? parent : $("body");

		$parent.find("textarea[data-counter]").each((i, el) => {
			const obj = $(el);

			// Already loaded
			if (obj.attr("data-counter-loaded")) {
				return;
			}

			// Loaded
			obj.attr("data-counter-loaded", true);

			if (
				!obj.closest(".textarea-wrap-counter").find(".field-counter-length")
					.length
			) {
				$('<div class="field-counter-length"></div>').insertAfter(obj);
			}

			obj
				.closest(".textarea-wrap-counter")
				.find(".field-counter-length")
				.text(obj.val().length + " / " + obj.attr("maxlength"));

			obj.on("input", (e) => {
				const obj = $(e.currentTarget);

				obj
					.closest(".textarea-wrap-counter")
					.find(".field-counter-length")
					.text(obj.val().length + " / " + obj.attr("maxlength"));
			});
		});
	};

	// Inicia Input Contador
	initInputContador();

	/*------------------------------------------------------
	 *  Fancybox
	 * ----------------------------------------------------- */
	if ($.fn.fancybox) {
		$.fancybox.defaults.animationEffect = "fade";
		$.fancybox.defaults.btnTpl.arrowLeft =
			'<button data-fancybox-prev class="fancybox-button fancybox-button--arrow_left" title="{{PREV}}"><i class="icon-arrow-c-left"></i></button>';
		$.fancybox.defaults.btnTpl.arrowRight =
			'<button data-fancybox-next class="fancybox-button fancybox-button--arrow_right" title="{{NEXT}}"><i class="icon-arrow-c-right"></i></button>';
		$.fancybox.defaults.btnTpl.smallBtn =
			'<button data-fancybox-close class="fancybox-close-small" title="{{CLOSE}}"><i class="icon-x-c"></i></button>';
		$.fancybox.defaults.backFocus = false;
		$.fancybox.defaults.autoFocus = false;
		//$.fancybox.defaults.thumbs.autoStart = true;
		$.fancybox.defaults.afterShow = (instance, current) => {
			// Init Validação
			initValidacao(current.$content);

			// Inicia Mascaras
			initMascaras(current.$content);

			// Inicia Placeholder
			initPlaceholder(current.$content);

			// Inicia Input Contador
			initInputContador(current.$content);

			// Inicia slider
			initSlides(current.$content);

			// Inicia Arquivo upload
			initArquivoUpload(current.$content);

			// Inicia Arquivo upload avançado
			initArquivoUploadAvancado(current.$content);

			// Inicia o plugin para select
			initSelect(current.$content);

			// Inicia video inline
			initVideoInline(current.$content);

			// Envia o change ao campo de estado
			let campo_estado = current.$content.find(".campo-estado");
			if (campo_estado.length) {
				campo_estado.change();
			}
		};
	}

	$(".search-container").on("click", (e) => {
		e.stopImmediatePropagation();
	});

	$(".search-container .btn-toggle-search").on("click", (e) => {
		$(".search-container .input-search-products").removeClass("uk-hidden");
	});

	/*------------------------------------------------------
	 *  Topo busca
	 * ----------------------------------------------------- */
	let $topo_busca = $(".input-search-products");

	if ($topo_busca.length) {
		let busca_topo_timeout = setTimeout(function () {}, 10);
		let $topo_busca_resultado_container = $topo_busca.find(".resultado-busca");
		let $topo_busca_resultado_lista =
			$topo_busca_resultado_container.find(".scroll-inner");
		let $topo_busca_campo = $topo_busca.find(".campo-busca");
		let topo_busca_buscou = false;
		let topo_busca_loading = false;
		let topo_busca_ajax;

		// Ao digitar no campo de busca
		$topo_busca_campo
			.on("keyup", function (e) {
				// Ctrl + A, 9 tab, 16 shift, 18 alt, 17 Ctrl, 37 seta left, 39 seta right
				if (
					(e.ctrlKey && e.keyCode == 65) ||
					e.keyCode == 9 ||
					e.keyCode == 16 ||
					e.keyCode == 18 ||
					e.keyCode == 17 ||
					e.keyCode == 37 ||
					e.keyCode == 39
				) {
					e.preventDefault();

					return false;
				}

				// Pega a busca
				let busca = $topo_busca_campo.val().trim();

				// Reinicia o timeout do ajax
				clearTimeout(busca_topo_timeout);

				// Aborta o ajax atual da busca
				if (topo_busca_ajax != null) {
					topo_busca_ajax.abort();
					topo_busca_ajax = null;
				}

				topo_busca_buscou = true;

				// Mostra a caixa de resultados
				$topo_busca_resultado_container.removeClass("hide");

				// Adiciona o loading se já não tiver
				if (
					!$topo_busca_resultado_lista.find(".resultado-loading-wrap").length
				) {
					$topo_busca_resultado_lista.html(
						'<div class="resultado-loading-wrap"><div class="loading-box"><div class="loading-animacao"></div></div></div>'
					);
				}

				topo_busca_loading = true;

				busca_topo_timeout = setTimeout(function () {
					topo_busca_ajax = $.ajax({
						url: AJAX_AUTOCOMPLETE_PRODUTOS,
						method: "GET",
						data: {
							busca: busca,
						},
						dataType: "json",
						cache: true,
					})
						.always(function (jqXHR, textStatus, errorThrown) {
							topo_busca_loading = false;
						})
						.fail(function (jqXHR, textStatus, errorThrown) {
							//if( textStatus !== 'abort' )
							//{
							//	swal('Request error!', textStatus, 'error');
							//}
						})
						.done(function (data, textStatus, jqXHR) {
							if (data.status === "refresh") {
								// Repete a busca
								$topo_busca_campo.trigger("keyup");

								return false;
							}

							let itens = "<div class='results-container'>";

							if (data.itens.length > 0) {
								for (let i = 0; i < data.itens.length; i++) {
									itens +=
										'<div class="result-item">' +
										"	<a href='" + data.itens[i].url + "'>" +
										"		" + data.itens[i].nome +
										"	</a>" +
										"</div>";
								}
							} else {
								itens +=
									'<div class="result-item not-found">Nenhum resultado foi encontrado.</div>';
							}

							itens += "</div>";

							$topo_busca_resultado_lista.html(itens);
						});
				}, 500);
			})
			.on("blur", function (e) {
				if (topo_busca_buscou && !topo_busca_loading) {
					topo_busca_buscou = false;
				}
			});

		// Ao clicar no site
		$(document).on("click", function (e) {
			$topo_busca_resultado_container.addClass("hide");
			$(".search-container .input-search-products").addClass("uk-hidden");
		});

		// Ao clicar na busca
		$topo_busca.on("click", function (e) {
			e.stopImmediatePropagation();
		});
	}

	/*------------------------------------------------------
	 *  Swipe slider
	 * ----------------------------------------------------- */
	/**
	 * @param parent - Caso queira aplicar aos filhos de um elemento do jQuery
	 */
	window.initSlides = (parent) => {
		if (typeof Swiper === "function") {
			// Se não definiu um elemento usa o body
			let $parent = parent ? parent : $("body");

			$parent.find("[data-slide]:not([data-slide-loaded])").each((i, el) => {
				let obj = $(el);

				let config_padrao = {
					init: false,
					navigation: {},
					pagination: {},
					scrollbar: {},
				};

				// Seta esq
				let prev = obj.find(".swiper-button-prev");
				if (prev.length) {
					config_padrao.navigation.prevEl = prev[0];
				}

				// Seta dir
				let next = obj.find(".swiper-button-next");
				if (next.length) {
					config_padrao.navigation.nextEl = next[0];
				}

				// Paginação
				let pagination = obj.find(".swiper-pagination");
				if (pagination.length) {
					config_padrao.pagination.el = pagination[0];
					config_padrao.pagination.clickable = true;

					// Se é paginação com números
					if (obj.hasClass("tipo-paginacao-numeros")) {
						config_padrao.pagination.renderBullet = (index, className) => {
							return (
								'<span class="' + className + '">' + (index + 1) + "</span>"
							);
						};
					}
				}

				// Barra de rolagem
				let scrollbar = obj.find(".swiper-scrollbar");
				if (scrollbar.length) {
					config_padrao.scrollbar.el = scrollbar[0];
				}

				// Cria o slide com as configurações padrão e as do objeto json
				const swiper = new Swiper(
					obj.find(".swiper-container")[0],
					$.extend({}, config_padrao, obj.data("slide") || {})
				);

				// Loop destruído
				swiper._loopDestroyed = false;

				// Informa que já foi carregado
				obj.attr("data-slide-loaded", true);

				if (obj.hasClass("parar-ao-passar-mouse")) {
					obj.mouseenter(() => {
						swiper.autoplay.stop();
					});

					obj.mouseleave(() => {
						swiper.autoplay.start();
					});
				}

				swiper.on("breakpoint", (swiper, breakpointParams) => {
					const config = $.extend({}, swiper.params, breakpointParams);

					const slideEl = $(config.el);

					// Loop desabilitado
					if (!config.loop) {
						return;
					}

					const total = slideEl.find(
						".swiper-slide:not(.swiper-slide-duplicate)"
					).length;

					if (
						config.slidesPerView !== "auto" &&
						total <= config.slidesPerView
					) {
						// Desativa o loop
						swiper.params.loop = false;

						setTimeout(() => {
							// Destrói o loop
							swiper.loopDestroy();

							// Informa que foi destruído
							swiper._loopDestroyed = true;
						}, 50);
					} else {
						// Se o loop já foi destruído
						if (swiper._loopDestroyed) {
							// Ativa o loop
							swiper.params.loop = true;

							// Recria o loop
							swiper.loopCreate();
						}
					}
				});

				// init Swiper
				swiper.init();
			});
		}
	};

	// Inicia os slides
	initSlides();

	/*------------------------------------------------------
	 *  Checkbox, Radio
	 * ----------------------------------------------------- */
	// Ao change do input
	$(document).on(
		"change",
		".checkbox-estilo input, .radio-estilo input",
		(e) => {
			let obj = $(e.currentTarget);
			let div_pai = obj.closest(".checkbox-estilo, .radio-estilo");

			// Se for radio
			if (obj.attr("type") === "radio") {
				// Remove a classe ativo dos outros radios com o mesmo nome
				// Se estiver dentro de algum form, então remove apenas do mesmo form
				if (obj.closest("form").length) {
					obj
						.closest("form")
						.find('input[type=radio][name="' + obj.attr("name") + '"]')
						.closest(".radio-estilo")
						.removeClass("ativo");
				} else {
					$('input[type=radio][name="' + obj.attr("name") + '"]')
						.closest(".radio-estilo")
						.removeClass("ativo");
				}
			}

			// Se estiver ativo
			if (obj.prop("checked") === true) {
				div_pai.addClass("ativo");
			} else {
				div_pai.removeClass("ativo");
			}
		}
	);

	// Envia o change inicial, assim se estiver selecionado ja ativa a div
	$(".checkbox-estilo input:checked, .radio-estilo input:checked").change();

	/*------------------------------------------------------
 	 *  Campo upload
 	 * ----------------------------------------------------- */
	window.initArquivoUpload = (parent) => {
		// Se não definiu um elemento usa o body
		let $parent = parent ? parent : $('body');

		// Ao clicar no campo temporário
		$parent.find('.arquivo-upload .arquivo_tmp').on('click', (e) => {
			$(e.currentTarget).closest('.arquivo-upload').find('input[type="file"]').click();
		});

		// Ao clicar no botão de remover
		$parent.find('.arquivo-upload .arquivo_tmp .botao-remover').on('click', (e) => {
			e.preventDefault();
			e.stopPropagation();

			// Reseta o campo
			$(e.currentTarget).closest('.arquivo-upload').find('input[type="file"]').val('').change();
		});

		// Ao selecionar o arquivo
		$parent.find('.arquivo-upload input[type="file"]').on('change', (e, data) => {
			let obj            = $(e.currentTarget);
			let arquivo_upload = obj.closest('.arquivo-upload');
			let nome_vazio     = arquivo_upload.attr('data-nome-vazio') ? arquivo_upload.attr('data-nome-vazio') : 'Nenhum arquivo selecionado...';
			let arquivo_nome   = arquivo_upload.find('.nome-arquivo');
			let arquivo        = obj.val().split("\\").pop();

			arquivo_nome.text(arquivo);

			if( !arquivo_nome.text() )
			{
				arquivo_nome.text(nome_vazio);
				arquivo_upload.removeClass('selecionado');
			}
			else
			{
				arquivo_upload.addClass('selecionado');
			}

			// Se não for o change inicial
			// Então valida o campo
			if( typeof data === 'undefined' || data.inicial !== true )
			{
				const form = obj.closest('form');

				// Se estiver dentro de um form
				if( form.length && form[0].fv )
				{
					const name = obj.attr('name');

					// Existe campo nos elementos da validação
					if( form[0].fv.getElements(name) )
					{
						form[0].fv.validateField(name);
					}
				}
			}
		}).trigger('change', {inicial: true});
	};

	// Inicia os arquivos
	initArquivoUpload();

	/*------------------------------------------------------
	 *  Campo upload avançado
	 * ----------------------------------------------------- */
	window.initArquivoUploadAvancado = (parent) => {
		// Se não definiu um elemento usa o body
		let $parent = parent ? parent : $('body');

		// Ao clicar no campo temporário
		$parent.find('.arquivo-upload-avancado .arquivo_tmp').on('click', (e) => {
			$(e.currentTarget).closest('.arquivo-upload-avancado').find('input[type="file"]').click();
		});

		// Ao clicar no botão de remover
		$parent.find('.arquivo-upload-avancado .arquivos-enviados').on('click', '.botao-remover', (e) => {
			e.preventDefault();
			e.stopPropagation();

			let obj            = $(e.currentTarget);
			let arquivo_upload = obj.closest('.arquivo-upload-avancado');
			let upload_unico   = arquivo_upload.hasClass('arquivo-upload-avancado-unico');

			obj.closest('.arquivo').remove();

			if( upload_unico )
			{
				arquivo_upload.removeClass('selecionado');
			}
		});

		// Ao soltar arquivos
		$parent.find('.arquivo-upload-avancado .arquivo_tmp').on('drag dragstart dragend dragover dragenter dragleave drop', (e) => {
			e.preventDefault();
			e.stopPropagation();
		})
		.on('dragover dragenter', (e) => {
			$(e.currentTarget).addClass('arquivo-hover');
		})
		.on('dragleave dragend drop', (e) => {
			$(e.currentTarget).removeClass('arquivo-hover');
		})
		.on('drop', (e) => {
			let obj            = $(e.currentTarget);
			let arquivo_upload = obj.closest('.arquivo-upload-avancado');

			arquivoUploadAvancadoUpload(arquivo_upload, e.originalEvent.dataTransfer.files);
		});

		// Ao selecionar os arquivos
		$parent.find('.arquivo-upload-avancado input[type="file"]').on('change', (e) => {
			let obj            = $(e.currentTarget);
			let arquivo_upload = obj.closest('.arquivo-upload-avancado');

			arquivoUploadAvancadoUpload(arquivo_upload, e.target.files);

			// Reseta o campo
			arquivo_upload.find('input[type="file"]').val('');
		});
	};

	window.arquivoUploadAvancadoUpload = (arquivo_upload, files) => {
		let upload_url        = arquivo_upload.attr('data-upload-url');
		let upload_unico      = arquivo_upload.hasClass('arquivo-upload-avancado-unico');
		let campo_ref_name    = arquivo_upload.attr('data-campo-ref-name');
		let arquivos_enviados = arquivo_upload.find('.arquivos-enviados');
		let botao             = arquivo_upload.closest('form').find('.btn-enviar');

		// Desabilita o botão
		if( botao.length )
		{
			botao.prop('disabled', true);
		}

		campo_ref_name = campo_ref_name ? campo_ref_name : 'arquivos';

		// Adiciona o loading
		arquivo_upload.append('<div class="loading-box"><div class="loading-animacao x2"></div></div>');

		let data = new FormData();

		if( upload_unico )
		{
			data.append('arquivos[0]', files[0]);
		}
		else
		{
			$.each(files, (i, file) => {
				data.append('arquivos[' + i + ']', file);
			});
		}

		// Se não há arquivo
		if( !data.has('arquivos[0]') )
		{
			if( botao.length )
			{
				// Habilita o botão
				botao.prop('disabled', false);
			}

			// Remove o loading
			arquivo_upload.find('.loading-box').remove();

			return false;
		}

		// Se for upload unico remove o selecionado e limpa os enviados
		if( upload_unico )
		{
			arquivo_upload.removeClass('selecionado');
			arquivos_enviados.empty();
		}

		$.ajax({
			url        : upload_url,
			method     : 'post',
			data       : data,
			dataType   : 'json',
			cache      : false,
			contentType: false,
			processData: false,
		}).always(() => {
			if( botao.length )
			{
				// Habilita o botão
				botao.prop('disabled', false);
			}

			// Remove o loading
			arquivo_upload.find('.loading-box').remove();
		}).fail((jqXHR, textStatus, errorThrown) => {
			const error = ajaxGetError(jqXHR);

			if( textStatus !== 'abort' )
			{
				Swal.fire(error.error_title, error.error_message, error.error_icon);
			}
		}).done((data, textStatus, jqXHR) => {
			if( data.status === 'sucesso' )
			{
				let itens = '';

				if( data.itens.length )
				{
					for( let i = 0; i < data.itens.length; i++ )
					{
						itens += '<div class="arquivo">' +
							'	<input type="hidden" name="' + campo_ref_name + '[]" value="' + data.itens[i].ref + '">' +
							'	<i class="icon-input-file-file"></i>' +
							'	<div class="nome-arquivo" class="uk-text-truncate">' + data.itens[i].nome + '</div>' +
							'	<div class="botao-remover">Apagar</div>' +
							'</div>';
					}

					if( upload_unico )
					{
						arquivo_upload.addClass('selecionado');
					}
				}

				arquivos_enviados.append(itens);
			}
			else
			{
				Swal.fire(data.titulo, data.mensagem, 'error');
			}
		});
	};

	// Inicia os arquivos
	initArquivoUploadAvancado();

	/*------------------------------------------------------
	 *  Select
	 * ----------------------------------------------------- */
	window.initSelect = (parent) => {
		// Se não definiu um elemento usa o body
		let $parent = parent ? parent : $("body");

		$parent
			.find("select:not([data-select-default]):not(.swal2-select)")
			.each((i, el) => {
				const obj = $(el);
				const url = obj.attr("data-url");

				const config = {
					language: "pt-BR",
					allowClear: true,
					width: "100%",
					minimumResultsForSearch: url ? 0 : 7,
				};

				if (url) {
					config.ajax = {
						url: url,
						dataType: "json",
						data: (params) => {
							return {
								busca: params.term,
								pagina: params.page,
							};
						},
						processResults: function (data, params) {
							// parse the results into the format expected by Select2
							// since we are using custom formatting functions we do not need to
							// alter the remote JSON data, except to indicate that infinite
							// scrolling can be used
							params.page = params.page || 1;

							return {
								results: data.itens,
								pagination: {
									more: data.hasOwnProperty("pagina_ultima")
										? data.pagina_ultima === false
										: false,
								},
							};
						},
						cache: true,
					};

					config.templateResult = (repo) => {
						if (repo.loading) {
							return repo.text;
						}

						return repo.nome;
					};

					config.templateSelection = (repo) => {
						return repo.id ? repo.nome : repo.text;
					};
				}

				obj
					.select2(config)
					.on("select2:open", (e) => {
						$(".select2-search--dropdown .select2-search__field").attr(
							"placeholder",
							"Pesquisar..."
						);
					})
					.on("select2:clearing", (e) => {
						// Limpa o campo manual para não abrir o select2 ao limpar
						e.preventDefault();
						e.stopImmediatePropagation();

						setTimeout(() => {
							const obj = $(e.currentTarget);

							obj.val(obj.prop("multiple") ? [] : null).trigger("change");
						}, 20);
					})
					.on("change.select2", (e, data) => {
						// Se não for o change inicial
						// Então valida o campo
						if (typeof data === "undefined" || data.inicial !== true) {
							const obj = $(e.currentTarget);
							const form = obj.closest("form");

							// Se estiver dentro de um form
							if (form.length && form[0].fv) {
								const name = obj.attr("name");

								// Existe campo nos elementos da validação
								if (form[0].fv.getElements(name)) {
									form[0].fv.validateField(name);
								}
							}
						}
					});
			});
	};

	// Inicia o plugin para select
	initSelect();

	/*------------------------------------------------------
	 *  Video inline
	 * ----------------------------------------------------- */
	window.youtubePlayers = [];

	window.loadYoutubeVideos = () => {
		if (window.YT && typeof window.YT.Player === "function") {
			window.onYouTubeIframeAPIReady();
		} else {
			const tag = document.createElement("script");
			tag.src = "https://www.youtube.com/iframe_api";

			const firstScriptTag = document.getElementsByTagName("script")[0];
			firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
		}
	};

	window.onYouTubeIframeAPIReady = () => {
		youtubePlayers.forEach((item) => {
			if (item.player) return;

			const obj = $("#" + item.id);

			item.player = new YT.Player(item.playerId, {
				width: "100%",
				height: "100%",
				videoId: obj.attr("data-youtube-id"),
				playerVars: {
					enablejsapi: 1,
					autoplay: obj[0].hasAttribute('data-autoplay') ? 1 : 0,
					controls: 0,
					modestbranding: 1,
					rel: 0,
					loop: 0,
					iv_load_policy: 3,
				},
				events: {
					onReady: (e) => {
						obj.addClass("loaded");
					},
					onStateChange: (e) => {
						obj.removeClass("paused playing end");

						if (e.data === YT.PlayerState.ENDED) {
							obj.addClass("end");
						} else if (e.data === YT.PlayerState.PAUSED) {
							obj.addClass("paused");
						} else if (e.data === YT.PlayerState.PLAYING) {
							obj.addClass("playing");
						}
					},
					onError: (e) => {
						let error_message = "Ocorreu um erro ao carregar o vídeo.";

						if (e.data === 2) {
							error_message = "ID do vídeo inválido.";
						} else if (e.data === 5) {
							error_message = "Ocorreu um erro no player HTML5.";
						} else if (e.data === 100 || e.data === 150) {
							error_message = "O vídeo não foi encontrado ou é privado.";
						} else if (e.data === 101) {
							error_message =
								"O proprietário do vídeo solicitado não permite que ele seja reproduzido em players incorporados.";
						}

						Swal.fire("", error_message, "error");
					},
				},
			});
		});
	};

	window.initVideoInline = (parent) => {
		// Se não definiu um elemento usa o body
		let $parent = parent ? parent : $("body");

		const $video_inline = $parent.find(".video-inline");

		if ($video_inline.length) {
			$video_inline.each((i, el) => {
				let playerWrapId =
					"yt-player-wrap-" + Math.floor(Math.random() * 10000);
				let playerId = "yt-player-" + Math.floor(Math.random() * 10000);
				const obj = $(el);
				const imagem = obj.attr("data-imagem");
				const hasImagem = !!imagem;
				let imagemHtml = "";

				if (el.hasAttribute("id")) {
					playerWrapId = obj.attr("id");
				} else {
					obj.attr("id", playerWrapId);
				}

				youtubePlayers.push({
					id: playerWrapId,
					playerId: playerId,
					player: null,
				});

				if (hasImagem) {
					imagemHtml += '<img src="' + imagem + '" uk-cover>';
				}

				obj.html(
					'<div id="' +
						playerId +
						'"></div>' +
						imagemHtml +
						'<div class="uk-position-cover acoes">' +
						'	<button type="button" title="Reproduzir" class="uk-button btn-play">' +
						'		<img class="button-play" src="https://sites.gazetamarista.com.br/engenhoterravermelha.com.br/common/default/images/Play.png">' +
						"	</button>" +
						'	<button type="button" title="Pausar" class="uk-button btn-pause">' +
						'		<i class="icon-pause-b uk-position-center"></i>' +
						"	</button>" +
						"</div>"
				);
			});

			$video_inline.find(".btn-play").on("click", (e) => {
				e.preventDefault();

				const obj = $(e.currentTarget).closest(".video-inline");

				const item = youtubePlayers.find((item) => item.id === obj.attr("id"));

				if (!item || !item.player) return;

				item.player.playVideo();
			});

			$video_inline.find(".btn-pause").on("click", (e) => {
				e.preventDefault();

				const obj = $(e.currentTarget).closest(".video-inline");

				const item = youtubePlayers.find((item) => item.id === obj.attr("id"));

				if (!item || !item.player) return;

				item.player.pauseVideo();
			});

			// Laod videos
			window.loadYoutubeVideos();
		}
	};

	// Inicia o video inline
	initVideoInline();

	/*------------------------------------------------------
	 *  Cep
	 * ----------------------------------------------------- */
	$(document).on("keyup", ".campo-cep", (e) => {
		// Ctrl + A, 9 tab, 16 shift, 18 alt, 17 Ctrl, 35 end, 36 home, 37 seta left, 39 seta right
		if (
			(e.ctrlKey && e.keyCode === 65) ||
			e.keyCode === 9 ||
			e.keyCode === 16 ||
			e.keyCode === 18 ||
			e.keyCode === 17 ||
			e.keyCode === 35 ||
			e.keyCode === 36 ||
			e.keyCode === 37 ||
			e.keyCode === 39
		) {
			e.preventDefault();

			return false;
		}

		const obj = $(e.currentTarget);
		const cep = obj.val().replace(/[^0-9]/g, "");

		// Se conter os 8 números
		if (cep.length === 8) {
			// Remove o focus do campo
			obj.blur();

			let grupo_localizacao = obj.closest(".grupo-localizacao");

			// Adiciona o loading
			grupo_localizacao.append(
				'<div class="loading-box"><div class="loading-animacao x2"></div></div>'
			);

			$.ajax({
				url: "https://viacep.com.br/ws/" + cep + "/json/",
				method: "GET",
				dataType: "jsonp",
				cache: false,
			})
				.always(() => {
					// Remove o loading
					grupo_localizacao.find(".loading-box").remove();
				})
				.fail((jqXHR, textStatus, errorThrown) => {
					const error = ajaxGetError(jqXHR);

					if (textStatus !== "abort") {
						Swal.fire(error.error_title, error.error_message, error.error_icon);
					}
				})
				.done((data, textStatus, jqXHR) => {
					if ("erro" in data) {
						Swal.fire("", "CEP não encontrado", "error");

						// Reseta o campo
						obj.val("");

						return false;
					}

					grupo_localizacao
						.find(".campo-cidade")
						.val(data.localidade)
						.attr("data-buscar-value", data.localidade)
						.change();
					grupo_localizacao
						.find(".campo-endereco")
						.val(data.logradouro)
						.change();
					grupo_localizacao.find(".campo-bairro").val(data.bairro).change();
					grupo_localizacao.find(".campo-estado").val(data.uf).change();

					const form = obj.closest("form");

					// Se estiver dentro de um form
					if (form.length && form[0].fv) {
						const campo_cidade_name = grupo_localizacao
							.find(".campo-cidade")
							.attr("name");
						const campo_endereco_name = grupo_localizacao
							.find(".campo-endereco")
							.attr("name");
						const campo_bairro_name = grupo_localizacao
							.find(".campo-bairro")
							.attr("name");
						const campo_estado_name = grupo_localizacao
							.find(".campo-estado")
							.attr("name");

						// Existe campo nos elementos da validação
						if (
							campo_cidade_name &&
							form[0].fv.getElements(campo_cidade_name)
						) {
							form[0].fv.validateField(campo_cidade_name);
						}

						if (
							campo_endereco_name &&
							form[0].fv.getElements(campo_endereco_name)
						) {
							form[0].fv.validateField(campo_endereco_name);
						}

						if (
							campo_bairro_name &&
							form[0].fv.getElements(campo_bairro_name)
						) {
							form[0].fv.validateField(campo_bairro_name);
						}

						if (
							campo_estado_name &&
							form[0].fv.getElements(campo_estado_name)
						) {
							form[0].fv.validateField(campo_estado_name);
						}
					}
				});
		}
	});

	/*------------------------------------------------------
	 *  Campo de estado e cidades
	 * ----------------------------------------------------- */
	// Ao trocar o estado
	$(document).on("change", ".campo-estado", (e) => {
		let obj = $(e.currentTarget);
		let grupo_localizacao = obj.closest(".grupo-localizacao");
		let uf = obj.val();
		let cidade_select = grupo_localizacao.find(".campo-cidade");

		if (
			!cidade_select.length ||
			cidade_select[0].nodeName.toLocaleLowerCase() !== "select"
		) {
			return;
		}

		let cidade_select_el = cidade_select[0];
		let cidade_label = cidade_select.attr("data-label");
		let cidade_value = cidade_select.attr("data-value");
		let cidade_buscar_value = cidade_select.attr("data-buscar-value");
		let cidade_pai = cidade_select.parent();
		let form = obj.closest("form");

		// Limpa o select
		cidade_select.empty();

		// Cria a primeira opção
		let option = document.createElement("option");
		option.value = "";
		option.textContent = cidade_label ? cidade_label : "Cidade";
		option.selected = true;
		cidade_select_el.appendChild(option);

		// Atualiza o select
		cidade_select.trigger("change", { inicial: true });

		if (!uf) return false;

		// Adiciona o loading
		cidade_pai.append(
			'<div class="loading-box"><div class="loading-animacao"></div></div>'
		);

		// Desabilita o estado
		obj.prop("disabled", true).blur();

		$.ajax({
			url: AJAX_CIDADES,
			method: "GET",
			data: {
				uf: uf,
			},
			dataType: "json",
			cache: false,
		})
			.always(() => {
				// Habilita o select de estado
				obj.prop("disabled", false);

				// Remove o loading
				cidade_pai.find(".loading-box").remove();

				setTimeout(() => {
					if (grupo_localizacao.find(".campo-endereco").val().length > 0) {
						grupo_localizacao
							.find(".campo-numero:not([readonly])")
							.trigger("focus");
					} else {
						grupo_localizacao
							.find(".campo-endereco:not([readonly])")
							.trigger("focus");
					}
				}, 50);
			})
			.fail((jqXHR, textStatus, errorThrown) => {
				const error = ajaxGetError(jqXHR);

				if (textStatus !== "abort") {
					Swal.fire(error.error_title, error.error_message, error.error_icon);
				}
			})
			.done((data, textStatus, jqXHR) => {
				let selecionado = false;

				for (let i = 0; i < data.itens.length; i++) {
					let option = document.createElement("option");
					option.textContent = data.itens[i].nome;
					option.value = data.itens[i].id;

					// Seleciona o valor padrão
					if (!selecionado) {
						if (cidade_buscar_value == data.itens[i].nome) {
							selecionado = true;
							option.selected = true;
						} else if (cidade_value == data.itens[i].id) {
							selecionado = true;
							option.selected = true;
						}
					}

					cidade_select_el.appendChild(option);
				}

				// Remove o atributo de buscar o valor da cidade
				cidade_select.removeAttr("data-buscar-value");

				// Atualiza o select
				cidade_select.trigger("change", { inicial: !selecionado });

				// Se estiver dentro de um form
				if (form.length && form[0].fv) {
					const name = cidade_select.attr("name");

					// Existe campo nos elementos da validação
					if (form[0].fv.getElements(name)) {
						form[0].fv.validateField(name);
					}
				}
			});
	});

	// Envia o change inicial
	$(".campo-estado").trigger("change", { inicial: true });

	/*------------------------------------------------------
	 *  Offcanvas principal
	 * ----------------------------------------------------- */
	const offcanvas_menu = $(".offcanvas-menu");

	if (offcanvas_menu.length) {
		const menu = new MmenuLight(offcanvas_menu[0]);

		window.navigation = menu.navigation();
		window.drawer = menu.offcanvas();

		$(".btn-menu-offcanvas-abrir").on("click", (e) => {
			e.preventDefault();

			const opcao = $(e.currentTarget).attr("data-opcao");

			if (opcao) {
				// Abre o submenu automatico
				offcanvas_menu.find('li[data-opcao="' + opcao + '"] > span').click();
			}

			window.drawer.open();
		});

		$("body").on("click", ".btn-menu-offcanvas-fechar", (e) => {
			e.preventDefault();

			window.drawer.close();

			// Reset Offcanvas
			window.resetOffcanvas();
		});

		$(".mm-ocd__backdrop").on("click", (e) => {
			// Reset Offcanvas
			window.resetOffcanvas();
		});

		window.resetOffcanvas = () => {
			// Reset menu
			offcanvas_menu.addClass("mm-spn--main").attr("data-mm-spn-title", "Menu");
			offcanvas_menu
				.find("ul")
				.removeClass("mm-spn--open")
				.removeClass("mm-spn--parent");
			offcanvas_menu.find("> ul:first-child").addClass("mm-spn--open");
		};
	}

	/*------------------------------------------------------
	 *  Desativa o scroll ao abir o menu mobile
	 * ----------------------------------------------------- */
	// const btnMenuMobile = $(".btn-menu");
	// if (btnMenuMobile) {
	// 	btnMenuMobile.on("click", function () {
	// 		$("body").toggleClass("fancybox-active compensate-for-scrollbar");
	// 	});
	// }

	/*------------------------------------------------------
	 *  Class body
	 * ----------------------------------------------------- */
	const siteCorpoClassBody = $("#site-corpo").attr("data-class-body");

	if (siteCorpoClassBody) {
		$("body").addClass(siteCorpoClassBody);
	}

	/*------------------------------------------------------
	 *  Ir para o topo
	 * ----------------------------------------------------- */
	$(".ir-para-topo").on("click", (e) => {
		$("html, body").animate({ scrollTop: 0 }, 500);
	});

	/*------------------------------------------------------
	 *  Cookies
	 * ----------------------------------------------------- */
	const cookies_container = $("#cookies");

	if (cookies_container.length) {
		// Adiciona evento ao click do remove imagem
		$(".aceitar-cookies").on("click", (e) => {
			let obj = $(e.currentTarget);

			// Fecha fancybox
			$.fancybox.close();

			cookies_container.fadeOut("fast");

			// Faz a requisição à exclusão
			$.ajax({
				url: obj.attr("data-href"),
				type: "POST",
			});
		});
	}

	/*------------------------------------------------------
	 *  Postar form ao trocar campo
	 *----------------------------------------------------- */
	const campo_postar_form_ao_trocar = $(".campo-postar-form-ao-trocar");

	if (campo_postar_form_ao_trocar.length) {
		// Ao trocar campo
		campo_postar_form_ao_trocar.on("change", (e) => {
			const obj = $(e.currentTarget);
			const form = obj.closest("form");

			if (form.length) {
				form.submit();
			}
		});
	}

	/*------------------------------------------------------
	 *  Trocar tipo do campo ao clicar no ícone de mostrar senha
	 *----------------------------------------------------- */
	const revealBtn = $("button.reveal-password");

	if (revealBtn.length) {
		revealBtn.on("click", function () {
			let btn = $(this);
			let input = $(this).parent().find("input");
			if (input.attr("type") == "password") {
				input.attr("type", "text");
				btn.find("i").removeClass("icon-eye");
				btn.find("i").addClass("icon-eye-closed");
			} else {
				input.attr("type", "password");
				btn.find("i").removeClass("icon-eye-closed");
				btn.find("i").addClass("icon-eye");
			}
		});
	}

	/*------------------------------------------------------
	 *  Focar no primeiro campo ao abrir modal e resetar form ao fechar modal
	 *----------------------------------------------------- */
	UIkit.util.on("*", "show", function (e) {
		setTimeout(
			() =>
				$(e.target)
					.find("input[name]:not([hidden]):not([readonly])")
					.first()
					.trigger("focus"),
			100
		);
	});

	UIkit.util.on("*", "hide", function (e) {
		$(e.target).find("form")[0]?.fv?.resetForm(true);
	});

	/*------------------------------------------------------
	 *  Campo de data auxiliar para mobile
	 *----------------------------------------------------- */
	$(".data-auxiliar").on("input change blur", function () {
		let value = $(this).val();
		let newValue = value.split("-").reverse().join("/");
		$(this).next().val(newValue);
	});

	/*------------------------------------------------------
	 *  Scroll topo ao abrir modais que preenchem a tela
	 *----------------------------------------------------- */
	UIkit.util.on("[uk-modal].uk-modal-full", "shown", function (e) {
		$("html, body").animate({ scrollTop: 0 }, 600);
	});

	/*------------------------------------------------------
	 *  Tradução
	 * ----------------------------------------------------- */
	window.initTradutor = function () {
		$(".translate-mobile-container button, #modal-traducao .buttons-container button").on("click", (e) => {
			e.preventDefault();
			const obj = $(e.currentTarget);
			const idioma = obj.data("idioma");

			UIkit.modal("#modal-traducao").hide();

			$(".translate-mobile-container button").removeClass("active");

			setTimeout(() => {
				$(".translate-mobile-container button[data-idioma='" + idioma + "']").addClass("active");
			}, 20);

			if( idioma === 'pt' )
			{
				$('.translate-container img.flag').attr('src', 'common/default/images/countries/br.svg');
				$('.translate-container span').text("PT");
				
				// Reseta o idioma
				$('.skiptranslate').contents().find('button[id=":1.restore"]').trigger("click");

				const btnClose = $('.skiptranslate').contents().find('.goog-close-link');

				if( btnClose.length )
				{
					let event = document.createEvent('HTMLEvents');
					event.initEvent('click', true, true);
					btnClose[0].dispatchEvent(event);
				}
			}
			else
			{
				// Altera idioma no google translate
				const select = $('#google_translate_element select');

				if( select.length )
				{
					select.val(idioma);

					let event = document.createEvent('HTMLEvents');
					event.initEvent('change', true, true);
					select[0].dispatchEvent(event);
				}
			}
		});
	};
	initTradutor();

	$('#google_translate_element').on('change', 'select', (e) => {
		changeLanguageCurrent();
	});

	function changeLanguageCurrent() {
		const language = $('#google_translate_element select').val();

		let name = '';
		let img  = '';

		if( language === 'pt' )
		{
			name = 'PT';
			img  = 'common/default/images/countries/br.svg';
		}
		else if( language === 'en' )
		{
			name = 'EN';
			img  = 'common/default/images/countries/us.svg';
		}
		else if( language === 'es' )
		{
			name = 'ES';
			img  = 'common/default/images/countries/es.svg';
		}

		if( name && img )
		{
			$('.translate-container img.flag').attr('src', img);
			$('.translate-container span').text(name);
			$(".translate-mobile-container button[data-idioma='" + language + "']").addClass("active");
		}
	}

	setTimeout(() => {
		changeLanguageCurrent();
	}, 1500);

	/*------------------------------------------------------
	 *  Whats flutuante
	 * ----------------------------------------------------- */
	window.initWhatsFlutuante = () => {
		const whats_btn = $(".whats-flutuante");
		// new Waypoint({
		// 	element: document.getElementById("site-rodape"),
		// 	handler: function (direction) {
		// 		whats_btn.toggle();
		// 	},
		// 	offset: 1250,
		// });
	};

	// Inicia o Whats flutuante
	initWhatsFlutuante();

	window.btnsLoadingHtml = {};

	window.addBtnLoading = (el) => {
		let button       = el instanceof jQuery ? el : $(el);
		let button_html  = button.html();
		let loading_text = button.attr("data-loading-text");
		let id           = Math.floor(Math.random() * 10000);
		let loading_svg  =
				'<svg class="btn-loading-svg" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="40px" height="40px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">' +
				'	<path opacity="0.4" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946' +
				"		s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634" +
				'		c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"/>' +
				'	<path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0' +
				'		C22.32,8.481,24.301,9.057,26.013,10.047z">' +
				'		<animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 20 20" to="360 20 20" dur="0.5s" repeatCount="indefinite"/>' +
				"	</path>" +
				"</svg>";

		window.btnsLoadingHtml[id] = button_html;

		// Disable button
		button.prop("disabled", true).addClass("btn-loading").html(loading_svg + (loading_text ? loading_text : "")).attr('data-btns-loading-html-id', id).blur();
	}

	window.removeBtnLoading = (el) => {
		let button      = el instanceof jQuery ? el : $(el);
		let id          = button.attr('data-btns-loading-html-id');
		let button_html = window.btnsLoadingHtml[id];

		button.prop("disabled", false).removeClass("btn-loading").html(button_html);
	}

	/*------------------------------------------------------
	 *  Evita fechar o drop de aplicar cep se o form estiver sendo enviado
	 *----------------------------------------------------- */
	UIkit.util.on(".cep-drop", "beforehide", function (e) {
		if($(".cep-drop .btn-enviar").hasClass("btn-loading")) {
			e.preventDefault();
		}
	});

	/*------------------------------------------------------
	 *  Função que atualiza e trata os dados do carrinho
	 *----------------------------------------------------- */
	window.atualizaCarrinho = ({ data }) => {
		// Exibe os alertas do carrinho caso exista algum
		if(data?.cart_alerts && data?.cart_alerts?.length > 0) {
			data.cart_alerts.forEach((alert) => {
				UIkit.notification({
					message: alert.message,
					pos: 'top-right',
					timeout: 6000,
				})
			})
		}

		// Atualiza o carrinho
		if($("body").hasClass("page-loja-carrinho")) {
			if(data?.cart_products?.length > 0) {
				let itens = "";
	
				for (let i = 0; i < data?.cart_products?.length; i++) {
					itens +=
					"<div class='cart-item' data-idproduto='" + data.cart_products[i].id + "'>" +
					"	<figure>" +
					"		<img data-src='" + data.cart_products[i].images[0].file_sizes.app_detail + "' data-width='76' data-height='76' uk-img alt='" + data.cart_products[i].name + "'>" +
					"	</figure>" +
					"	<div class='info'>" +
					"		<h3>" + data.cart_products[i].name + "</h3>" +
					"		<p class='price'>" + formatter.format(data.cart_products[i].total) + "</p>" +
					"		<div class='right-container'>" +
					"			<div class='product-quantity'>" +
					"				<button type='button' class='uk-button uk-button-default btn-remove'>-</button>" +
					"				<input type='text' name='quantidade' class='uk-input mascara-numero' data-value='" + data.cart_products[i].quantity + "' value='" + data.cart_products[i].quantity + "' required>" +
					"				<button type='button' class='uk-button uk-button-default btn-add'>+</button>" +
					"			</div>" +
					"			<button type='button' class='uk-button btn-remove-cart'><i class='icon-trash-b'></i></button>" +
					"		</div>" +
					"	</div>" +
					"</div>";
				}

				$(".cart-container").html(itens);
			} else {
				$(".cart-container").empty().slideUp(200);
				$(".btn-payment").prop("disabled", true);

				setTimeout(() => {
					$(".cart-empty").slideDown(200);
				});
			}
		}
		
		$("#total-produtos").text(data?.total_produtos);
		$(".total-value").text(data?.total_valor);
		$("#parcelas").text(data?.parcelas);
	}
});


/*------------------------------------------------------
 *  Formatação de números
 * ----------------------------------------------------- */
window.number_format = function (number, decimals, decPoint, thousandsSep) {
	number = (number + "").replace(/[^0-9+\-Ee.]/g, "");
	let n = !isFinite(+number) ? 0 : +number;
	let prec = !isFinite(+decimals) ? 0 : Math.abs(decimals);
	let sep = typeof thousandsSep === "undefined" ? "," : thousandsSep;
	let dec = typeof decPoint === "undefined" ? "." : decPoint;
	let s = "";
	let toFixedFix = function (n, prec) {
		let k = Math.pow(10, prec);
		return "" + (Math.round(n * k) / k).toFixed(prec);
	};
	// @todo: for IE parseFloat(0.55).toFixed(0) = 0;
	s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
	if (s[0].length > 3) {
		s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	}
	if ((s[1] || "").length < prec) {
		s[1] = s[1] || "";
		s[1] += new Array(prec - s[1].length + 1).join("0");
	}
	return s.join(dec);
};
