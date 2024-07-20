<!doctype html>
<!--[if IE 8 ]><html class="no-js ie8 oldie lt-ie9" lang="pt"><![endif]-->
<!--[if IE 9 ]><html class="no-js ie9 lt-ie10" lang="pt"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html class="no-js" lang="pt"><!--<![endif]-->
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

		<!-- Favicon Apple -->
		<link rel="apple-touch-icon" sizes="57x57" href="{$imagePath}/favicon/57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="{$imagePath}/favicon/60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="{$imagePath}/favicon/72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="{$imagePath}/favicon/76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="{$imagePath}/favicon/114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="{$imagePath}/favicon/120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="{$imagePath}/favicon/144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="{$imagePath}/favicon/152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="{$imagePath}/favicon/180x180.png">

		<!-- Outros Favicons -->
		<link rel="icon" type="image/png" sizes="192x192"  href="{$imagePath}/favicon/192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="{$imagePath}/favicon/32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="{$imagePath}/favicon/96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="{$imagePath}/favicon/16x16.png">

		<!-- Splash Screen PWA -->
		<link href="{$imagePath}/splashscreens/iphone5_splash.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
		<link href="{$imagePath}/splashscreens/iphone6_splash.png" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
		<link href="{$imagePath}/splashscreens/iphoneplus_splash.png" media="(device-width: 621px) and (device-height: 1104px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
		<link href="{$imagePath}/splashscreens/iphonex_splash.png" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
		<link href="{$imagePath}/splashscreens/iphonexr_splash.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
		<link href="{$imagePath}/splashscreens/iphonexsmax_splash.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
		<link href="{$imagePath}/splashscreens/ipad_splash.png" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
		<link href="{$imagePath}/splashscreens/ipadpro1_splash.png" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
		<link href="{$imagePath}/splashscreens/ipadpro3_splash.png" media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
		<link href="{$imagePath}/splashscreens/ipadpro2_splash.png" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />

		<!-- Manifest PWA -->
		<link rel="manifest" href="{$imagePath}/favicon/site_manifest.json">

		<!-- Outras informações PWA -->
		<link rel="mask-icon" href="{$imagePath}/favicon/safari-pinned-tab.svg" color="#d33535">
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
			<!-- https://browser-update.org/pt/ -->
			<script>
				var $buoop = {required:{e:-3,f:-3,o:-3,s:-3,c:-3},insecure:true,style:"bottom",api:2019.10 };
				function $buo_f() {
 					var e = document.createElement("script");
					e.src = "//browser-update.org/update.min.js";
 					document.body.appendChild(e);
				};
				try { document.addEventListener("DOMContentLoaded", $buo_f,false) }
					catch(e){window.attachEvent("onload", $buo_f)}
			</script>
		{/literal}
	</head>
	
	<body>
		<main id="site-corpo" class="pagina-{$currentAction}">
			<div class="small-12 medium-4 large-4 columns formulario">
				<div class="box">
					<div class="image">
						<img src="{$basePath}/common/admin/images/logos/logo-marista.png" alt="">
					</div>
					<form enctype="application/x-www-form-urlencoded" action="{$this->CreateUrl('login', 'usuarios', 'admin', [], TRUE)}" method="post" data-abide>
						<div>
							<label for="login" class="required">Username</label>
							<input type="text" name="login" id="login" placeholder="Nome do usuário" field-type="text" class="radius string" required tabindex="1">
						</div>
						<div>
							<label for="senha" class="required">Senha</label>
							<input type="password" name="senha" id="senha" placeholder="●●●●●●●●●●●●" field-type="password" class="radius string password" required tabindex="2">
						</div>
						<div>
							<input type="submit" name="submit" id="submit" value="Entrar" class="button expand radius success" tabindex="3">
						</div>
					</form>
				</div>
			</div>
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

		<script type="text/javascript">
			{if $success|default:"" != ""}
				swal({
				  title: "Sucesso!",
				  text: "{$success}",
				  type: "success",
				  showConfirmButton: false,
				  timer: 2000,
				  onOpen: () => {
				    swal.showLoading()
				  }
				});
            {/if}
            {if $error|default:"" != ""}
                swal('Ops!', '{$error}', 'error');
            {/if}
    	</script>

	</body>
</html>
