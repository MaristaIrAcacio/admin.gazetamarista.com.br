<!doctype html>
<html class="no-js" lang="pt">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<meta name="format-detection" content="telephone=no">
	<meta name="msapplication-tap-highlight" content="no">

	<!-- Favicon Principal -->
	<link rel="shortcut icon" type="image/png" href="{$imagePath}/favicon/32x32.png">

	<meta name="apple-mobile-web-app-title" content="CW Panel">
	<meta name="application-name" content="CW Panel">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="theme-color" content="#ffffff">
	<meta name="msapplication-TileImage" content="{$imagePath}/favicon/180x180.png">

	{$this->headTitle()}
	{$this->headMeta()}
	{$this->headLink()}

	<script>
		document.basePath = '{$basePath}';
		document.openedController = '{$openedController}';
		document.nomeUser = '{$logged_usuario["nome"]}';

		var _GLOBALS = window._GLOBALS = {
			basePath: '{$basePath}',
			imagePath: '{$imagePath}',
			currentModule: '{$currentModule}',
			currentController: '{$currentController}',
			currentAction: '{$currentAction}',
			permitidoAdicionar: "{$_permitidoAdicionar}",
			permitidoEditar: "{$_permitidoEditar}",
			permitidoExcluir: "{$_permitidoExcluir}",
			permitidoVisulizar: "{$_permitidoVisulizar}"
		};
	</script>

	{literal}
	<!-- Verifica a versão do Navegador, e exibi uma mensagem de alerta caso esteja desatualizada -->
	<script>
		var $buoop = { required: { e: -3, f: -3, o: -3, s: -3, c: -3 }, insecure: true, style: "bottom", api: 2019.10 };
		function $buo_f() {
			var e = document.createElement("script");
			e.src = "//browser-update.org/update.min.js";
			document.body.appendChild(e);
		};
		try { document.addEventListener("DOMContentLoaded", $buo_f, false) }
		catch (e) { window.attachEvent("onload", $buo_f) }
	</script>
	{/literal}

	<!-- Configura o Recaptcha no Formulário -->
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<body>
	<main id="site-corpo" class="pagina-{$currentAction}">
		<section class="ftco-section">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-12 col-lg-10">
						<div class="wrap d-md-flex">
							{assign var="path"
							value="{$basePath}/common/admin/images/tres-coisas-que-para-ser-redator-voce-tem-que-gostar.png"}
							<div class="img" style="background-image: url({$path});">
							</div>
							<div class="login-wrap p-4 p-md-5">
								<div class="d-flex">
									<div class="w-100">
										<div class="image">
											<img width="60px" height="60px"
												src="{$basePath}/common/admin/images/logos/logo-marista.png" alt="">
										</div>
										<form enctype="application/x-www-form-urlencoded"
											action="{$this->CreateUrl('login', 'usuarios', 'admin', [], TRUE)}"
											method="post" data-abide class="signin-form">
											<div class="form-group mb-3">
												<label class="label" for="name">Usuário</label>
												<input type="text" name="login" id="login" class="form-control"
													placeholder="Username" required>
											</div>
											<div class="form-group mb-3">
												<label class="label" for="password">Senha</label>
												<input type="password" name="senha" id="senha" class="form-control"
													placeholder="Password" required>
											</div>
											<div class="form-group mb-3">
												<div class="g-recaptcha"
													data-sitekey="6LeLQRkqAAAAAP0wmJ62mpvJfYZBAmaftc3Mvarj"></div>
											</div>
											<div class="form-group">
												<button type="submit"
													class="form-control btn btn-primary rounded submit px-3">Acessar
													Painel</button>
											</div>
										</form>
										<p class="text-center">Não é um membro do Projeto Conexão? <a href="#">Conheça nosso Jornal</a></p>
									</div>
								</div>
							</div>
						</div>
					</div>
		</section>
	</main>

	{$this->headScript()}

	<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>

	<!-- Obrigatório em todas as páginas -->
	{literal}
	<script type="text/javascript">
		/**
		* Foundation
		**/
		$(document).foundation();
	</script>
	{/literal}

</body>
</html>