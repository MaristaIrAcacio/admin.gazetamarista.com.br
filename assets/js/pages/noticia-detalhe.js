import {ajaxGetError} from "../helpers";
import {AJAX_LIKE_DESLIKE} from '../api';

$(document).ready(() => {
	let $site_corpo = $('#site-corpo');

	if( $site_corpo.hasClass('main-noticia-detalhe') )
	{
		var idPost = parseInt($('#idpost').val());

		let hasLikedUnparsed = window.localStorage.getItem(`RKADVISORS_POST${idPost}`);
		let hasLiked = JSON.parse(hasLikedUnparsed);
		if (hasLiked && hasLiked.action) {
			if (hasLiked.action === 'like') {
				$(".like").addClass("liked");
			} else {
				$(".unlike").addClass("disliked");
			}
		}

		$(".like").on("click", function () {
			$(".like").addClass("loading");

			$.ajax({
				url: AJAX_LIKE_DESLIKE,
				data: {id: idPost, like: 1},
				dataType: "json",
				cache: false,
				timeout: 10000,
			})
				.fail(function (jqXHR, textStatus) {
					const error = ajaxGetError(jqXHR);
					if (textStatus !== "abort") {
						Swal.fire(
							error.error_title,
							error.error_message,
							error.error_icon
						);
					}
					$(".like").removeClass("loading");
				})
				.done(async function (data) {
					if (data.status === "erro") {
						Swal.fire(data.titulo, data.mensagem, "error");
						return false;
					} else {
						if ($(".like").hasClass("liked")) {
						} else {
							// NÃO FOI CURTIDO, CURTIR
							handleStorage("set", "RKADVISORS_POST" + idPost, "like");

							$(".like").addClass("liked");

							// VERIFICA SE O UNLIKE ESTÁ ATIVO E DESATIVA
							if ($(".unlike").hasClass("disliked")) {
								// DESATIVA O UNLIKE
								$(".unlike").removeClass("disliked");
							}
						}
					}
					$(".like").removeClass("loading");
				});
		});

		$(".unlike").on("click", function () {
			$(".unlike").addClass("loading");

			$.ajax({
				url: AJAX_LIKE_DESLIKE,
				data: {id: idPost, unlike: 1},
				dataType: "json",
				cache: false,
				timeout: 10000,
			})
				.fail(function (jqXHR, textStatus) {
					const error = ajaxGetError(jqXHR);
					if (textStatus !== "abort") {
						Swal.fire(
							error.error_title,
							error.error_message,
							error.error_icon
						);
					}
					$(".unlike").removeClass("loading");
				})
				.done(async function (data) {
					if (data.status === "erro") {
						Swal.fire(data.titulo, data.mensagem, "error");
						return false;
					} else {
						// UNLIKE TOGGLE
						if ($(".unlike").hasClass("disliked")) {
						} else {
							// NAO FOI MARCADO, INSERIR
							handleStorage("set", "RKADVISORS_POST" + idPost, "unlike");

							$(".unlike").addClass("disliked");

							// VERFIICA SE O LIKE TA ATIVO E DESATIVA
							if ($(".like").hasClass("liked")) {
								// FOI CURTIDO, TIRAR CURTIDA
								$(".like").removeClass("liked");
							}
						}
					}
					$(".unlike").removeClass("loading");
				});
		});

		const handleStorage = async (action, storage, value) => {
			if (action === "get") {
				return window.localStorage.getItem(storage);
			} else if (action === "set") {
				await window.localStorage.removeItem(storage);
				const data = window.localStorage.setItem(
					storage,
					JSON.stringify({date: new Date(), action: value})
				);
				return data;
			} else if (action === "delete") {
				window.localStorage.removeItem(storage);
			}
		};
	}
});