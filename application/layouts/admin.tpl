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

		<link type="text/css" rel="stylesheet" media="print" href="{$basePath}/common/admin/css/impressaogeral.css">

		<!--[if lt IE 9]>
			<script src="{$basePath}common/default/js/ie8.js" type="text/javascript"></script>
		<![endif]-->

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
	</head>

	<body>
		<!-- Preloader carregar conteúdo página -->
        <div id="preloader">
            <div class="status">&nbsp;</div>
        </div>

		<!-- Menu off-canvas começa aqui e termina no site_html_footer -->
		<div class="off-canvas-wrap menu-principal-off-wrap" data-offcanvas>
			<div class="inner-wrap">
				<aside class="left-off-canvas-menu menu-navegacao-off-left">
					<div class="blocK-canvas-menu">
						<div class="icon-bar nodirecthover">
							<a href="#" class="btn-abrir-menu btn-abrir-menu-navegacao-off text-right">
								<i class="mdi mdi-close-circle-outline" style="color: #fff; font-size: 2.125rem;"></i>
							</a>
						</div>
						<p class="clearfix"></p>
						<p class="clearfix"></p>
						{$this->navigation()->menu()}
					</div>
				</aside>
				<div class="row collapse">
					<div class="medium-2 columns show-for-medium-up menu-navegacao-off-left">
						<div class="icon-bar vertical one-up">

							<a class="logo-usuario small-9 medium-5 large-6 columns left small-only-text-center title-project">
								
								{if $logged_usuario["avatar"]}
									<img src="{$basePath}/common/uploads/usuarios/{$logged_usuario["avatar"]}" alt="Usuário"/>
								{else}
									<img src="{$basePath}/common/uploads/usuarios/default.png" alt="Usuário"/>
								{/if}

								{if $logged_usuario["nome"]}
									<h1 class="titulo-usuario">{implode(' ', array_slice(explode(' ', $logged_usuario["nome"]), 0, 2))}</h1>
								{else}
									<h1 class="titulo-usuario">Usuário Anônimo</h1>
								{/if}
							</a>

							{$this->navigation()->menu()}

							<div class="btnsPrincipais">
								<a class="BtnLogout" href="{$this->url(['module'=>'admin', 'controller'=>'usuarios', 'action'=>'logout'], 'default', TRUE)}">
									<span class="mdi mdi-logout-variant"></span>
									<span>Sair</span>
								</a>
							</div>

						</div>
					</div>

					<div class="small-12 medium-10 columns bodyFramework">
						<header id="header-framework">

							<div class="row btn-menu-mobile" data-equalizer data-options="equalize_on_stack:true" data-equalizer-mq="medium-up">
								<div class="small-12 medium-2 columns show-for-small-only">
									<div class="icon-bar left offcanvas-hide">
										<a href="#" class="btn-abrir-menu btn-abrir-menu-navegacao-off text-center">
											<i class="mdi mdi-menu" style="color: #fff; font-size: 2.125rem;"></i>
											Menu
										</a>
									</div>
								</div>
							</div>

							{if $currentController != 'index'}
								<div class="row sub_header" >
									<div class="small-12 columns">
										{$this->navigation()->breadcrumbs()->setLinkLast(TRUE)->setSeparator(' - ')->setMinDepth(-1)->setPartial(array('breadcrumbs.tpl','admin'))}
									</div>
								</div>
							{else}
								<div class="row sub_header" >
									<div class="small-12 columns">
										<ul class="breadcrumbs">
											<li class="unavailable">Dashboard</li>
										</ul>
										<h2 style="text-transform: capitalize;">Dashboard</h2>

									</div>
								</div>
							{/if}
						</header>

						<main id="site-corpo" class="pagina-{$currentAction}">
							{$this->layout()->content}
						</main>
					</div>
				</div>
				<a class="menu-principal-off-overlay"></a>
			</div>
		</div>
		<!-- Final do Menu off-canvas -->

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
				{$timer_seconds = 2500}
				{if $success|count_characters:true > 40}{$timer_seconds = 5000}{/if}
				{if $success|count_characters:true > 60}{$timer_seconds = 7000}{/if}
				swal({
				  title: "Sucesso!",
				  text: "{$success}",
				  type: "success",
				  showConfirmButton: false,
				  timer: {$timer_seconds},
				  onOpen: () => {
				    swal.showLoading()
				  }
				});
            {/if}
            {if $error|default:"" != ""}
                swal({
				  title: "Ops!",
				  text: "{$error}",
				  type: "error",
				  showConfirmButton: true
				});
            {/if}
    	</script>

	</body>
</html>
