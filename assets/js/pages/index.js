$(document).ready(() => {
	let $site_corpo = $('#site-corpo');

	if ($site_corpo.hasClass('main-index')) {
		$(".video img").on('click', function () {
			let url = $(this).closest('.video').attr('data-url');
			if (url != undefined) {
				let video = `<iframe width="${$(this).width()}" height="${$(this).height()}" src="${url}?autoplay=1&rel=0&controls=0&showinfo=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen autoplay></iframe>`
				$(".video").html(video)
			}
		})
	}


	const container = document.getElementById("proposito");
	const checkbox = document.getElementById("continue-lendo");
	const btnText = document.getElementById("proposito-btntext")
	checkbox.addEventListener("change", () => {
		const ativo = checkbox.checked;
		container.style.maxHeight = ativo ? "100%" : "300px";
		container.style.zIndex = ativo ? "101" : "0";
		btnText.innerHTML = ativo ? "Ver Menos" : "Continue lendo";
		container.classList.toggle("no-shadow");
	});

	const emailInput = document.getElementById('email');

	// Verifica a largura da tela ao carregar e redimensionar
	function setPlaceholder() {
		if (window.innerWidth < 640) {
			emailInput.placeholder = 'RECEBA NOSSAS NOVIDADES';
		} else {
			emailInput.placeholder = 'INSIRA SEU E-MAIL E RECEBA NOSSAS NOVIDADES';
		}
	}

	setPlaceholder();

	window.addEventListener('resize', setPlaceholder);
});
