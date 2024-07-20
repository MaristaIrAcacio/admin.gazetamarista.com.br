<!doctype html>
<!--[if IE 8 ]><html class="no-js ie8 oldie lt-ie9" lang="pt"><![endif]-->
<!--[if IE 9 ]><html class="no-js ie9 lt-ie10" lang="pt"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html class="no-js" lang="pt"><!--<![endif]-->
	<head>
	<!--
     .o88b. db      d888888b  .o88b. db   dD db   d8b   db d88888b d8888b.
    d8P  Y8 88        `88'   d8P  Y8 88 ,8P' 88   I8I   88 88'     88  `8D
    8P      88         88    8P      88,8P   88   I8I   88 88ooooo 88oooY'
    8b      88         88    8b      88`8b   Y8   I8I   88 88~~~~~ 88~~~b.
    Y8b  d8 88booo.   .88.   Y8b  d8 88 `88. `8b d8'8b d8' 88.     88   8D
     `Y88P' Y88888P Y888888P  `Y88P' YP   YD  `8b8' `8d8'  Y88888P Y8888P'   -->

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
							<a href="{$this->url(['module'=>'admin', 'controller'=>'index', 'action'=>'index'], 'default', TRUE)}" class="Logo logo-branca small-9 medium-5 large-6 columns left small-only-text-center title-project">
								<img src="{$basePath}/common/admin/images/logos/logo_bkp.png" alt="Logo" style="height: 4.250rem; width: 10.875rem" />
							</a>

							{$this->navigation()->menu()}

							<div class="btnsPrincipais">
								<a class="BtnLogout" href="{$this->url(['module'=>'admin', 'controller'=>'usuarios', 'action'=>'logout'], 'default', TRUE)}">
									<span>Sair</span>
								</a>

								<a class="BtnSettings" href="{$this->url(['module'=>'admin', 'controller'=>'usuarios', 'action'=>'trocarsenha'], 'default', TRUE)}" title="Trocar senha">
									<i class="mdi mdi-textbox-password"></i>
								</a>

								{if $logged_usuario["idperfil"] > 2}
									<a class="BtnSettings" href="{$this->url(['module'=>'admin', 'controller'=>'configuracoes', 'action'=>'form', 'idconfiguracao'=>'1'], 'default', TRUE)}" title="Alterar Configurações do Site">
										<i class="mdi mdi-settings"></i>
									</a>
								{/if}
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

									<a href="{$this->url(['module'=>'admin', 'controller'=>'index', 'action'=>'index'], 'default', TRUE)}" class="Logo logo-branca small-9 medium-5 large-6 columns left small-only-text-center title-project">
										<img src="{$basePath}/common/admin/images/logos/logo.png" alt="Logo" />
									</a>
								</div>
								<div class="dadosGerais" style="display: none;">
									{*<div class="small-9 medium-5 large-6 columns left small-only-text-center title-project" data-equalizer-watch>*}
										{*<h1>*}
											{*<img src="{$imagePath}/logos/logo.png" alt="{$_title}">*}
										{*</h1>*}
									{*</div>*}
									{*<div class="small-12 medium-7 large-6 columns coluna-menu" data-equalizer-watch>*}
										{*<button data-dropdown="usuariodrop" aria-controls="usuariodrop" aria-expanded="false" class="right dropdown usuariodrop" data-options="is_hover:true; hover_timeout:200">*}
											{*<span class="left" style="padding-right:15px;">{$logged_usuario['nome']}</span>*}
											{*<i class="mdi mdi-account"></i>*}
										{*</button>*}
										{*<ul id="usuariodrop" data-dropdown-content class="f-dropdown" role="menu" aria-hidden="false" tabindex="-1">*}
											{*<li>*}
												{*<a href="{$this->url(['module'=>'admin', 'controller'=>'index', 'action'=>'index'], 'default', TRUE)}">*}
													{*<i class="mdi mdi-view-dashboard"></i>*}
													{*<span>Dashboard</span>*}
												{*</a>*}
											{*</li>*}
											{*<li>*}
												{*<a href="{$this->url(['module'=>'admin', 'controller'=>'usuarios', 'action'=>'logout'], 'default', TRUE)}">*}
													{*<i class="mdi mdi-close-circle-outline"></i>*}
													{*<span>Sair</span>*}
												{*</a>*}
											{*</li>*}
										{*</ul>*}
									{*</div>*}
								</div>
							</div>

							{if $currentController != 'index'}
								<div class="row sub_header" >
									<div class="small-12 columns">
										{$this->navigation()->breadcrumbs()->setLinkLast(TRUE)->setSeparator(' - ')->setMinDepth(-1)->setPartial(array('breadcrumbs.tpl','admin'))}

{*										<a class="BtnSettings" href="{$this->url(['module'=>'admin', 'controller'=>'configuracoes', 'action'=>'form', 'idconfiguracao'=>'1'], 'default', TRUE)}" title="Dúvidas sobre como o nosso painel funciona ?">*}
{*											<i class="mdi mdi-comment-question-outline"></i>*}
{*										</a>*}

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

						<footer id="footer-framework">
							<div class="row">
								<div class="small-12 columns text-right footer-developer">
									<span>Desenvolvido por</span>
									<a href="http://gazetamarista.com.br/">
										<div class="logo-rodape">
											<svg version="1.1" id="Layer_2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 372 137" style="enable-background:new 0 0 372 137;" xml:space="preserve">
												<path class="logo-bolas" d="M341.22,113.72c-2.08,0-3.76,1.68-3.76,3.76c0,2.07,1.68,3.75,3.76,3.75c2.08,0,3.76-1.68,3.76-3.75C344.98,115.4,343.3,113.72,341.22,113.72z M353.21,97.45c-3.33,0-6.02,2.69-6.02,6.01c0,3.32,2.7,6.01,6.02,6.01c3.32,0,6.02-2.69,6.02-6.01C359.23,100.14,356.54,97.45,353.21,97.45z M355.2,68.81c-5.32,0-9.63,4.3-9.63,9.61c0,5.31,4.31,9.61,9.63,9.61c5.32,0,9.63-4.3,9.63-9.61C364.83,73.11,360.52,68.81,355.2,68.81z M354.58,45.38c0-8.5-6.9-15.38-15.41-15.38c-8.51,0-15.41,6.89-15.41,15.38c0,8.49,6.9,15.38,15.41,15.38C347.68,60.76,354.58,53.88,354.58,45.38z M287.13,4.69c-13.62,0-24.66,11.02-24.66,24.61s11.04,24.61,24.66,24.61s24.66-11.02,24.66-24.61S300.75,4.69,287.13,4.69z"/>
												<path class="logo-letras" d="M32.38,76.92c-4.17,0-7.85,0.86-11.02,2.57c-3.17,1.71-5.85,3.93-8.02,6.64c-2.17,2.72-3.82,5.77-4.93,9.17c-1.11,3.4-1.67,6.79-1.67,10.16c0,5.54,1.51,9.9,4.54,13.08c3.03,3.17,7.8,4.76,14.32,4.76c2.46,0,4.72-0.17,6.77-0.51c2.06-0.34,4-0.91,5.83-1.71c0-2.34-0.2-4.23-0.6-5.66c-0.4-1.43-0.92-2.66-1.54-3.69c-1.83,0.74-3.36,1.23-4.59,1.46c-1.23,0.23-2.47,0.34-3.73,0.34c-2.46,0-4.49-0.74-6.09-2.23c-1.6-1.48-2.4-3.8-2.4-6.95c0-2.29,0.27-4.49,0.81-6.6c0.54-2.11,1.37-3.99,2.49-5.62c1.11-1.63,2.5-2.94,4.16-3.95c1.66-1,3.6-1.5,5.83-1.5c1.49,0,2.84,0.14,4.07,0.43c1.23,0.29,2.47,0.69,3.73,1.2c0.97-1.54,1.69-3.16,2.14-4.84c0.46-1.69,0.71-3.27,0.77-4.76c-1.66-0.63-3.4-1.08-5.23-1.37C36.21,77.07,34.32,76.92,32.38,76.92z"/>
												<path class="logo-letras" d="M65.27,112.42c-0.51,0.17-1.09,0.3-1.71,0.38c-0.63,0.09-1.06,0.13-1.29,0.13c-0.51,0-1.03-0.04-1.54-0.13c-0.51-0.08-0.97-0.27-1.37-0.56c-0.4-0.29-0.73-0.69-0.99-1.2c-0.26-0.51-0.39-1.23-0.39-2.14c0-0.63,0.09-1.43,0.26-2.4l6.6-34.47c0.34-1.83,0.63-3.51,0.86-5.06c0.23-1.54,0.34-2.91,0.34-4.12c0-1.31-0.14-2.4-0.43-3.26c-2-0.34-3.83-0.51-5.49-0.51c-0.91,0-2,0.04-3.26,0.13c-1.26,0.09-2.37,0.21-3.34,0.39c0.06,0.51,0.1,0.99,0.13,1.41c0.03,0.43,0.04,0.96,0.04,1.59c0,1.54-0.13,3.44-0.39,5.7c-0.26,2.26-0.7,4.9-1.33,7.93l-5.66,29.32c-0.17,0.97-0.32,1.9-0.43,2.79c-0.12,0.89-0.17,1.73-0.17,2.53c0,4.12,1.12,7.13,3.34,9.05c2.23,1.92,5.29,2.87,9.17,2.87c1.66,0,3.17-0.1,4.54-0.3c1.37-0.2,2.49-0.47,3.34-0.81c0.06-0.46,0.1-0.88,0.13-1.29c0.03-0.4,0.04-0.83,0.04-1.29c0-1.2-0.1-2.37-0.3-3.52C65.8,114.45,65.55,113.39,65.27,112.42z"/>
												<path class="logo-letras" d="M75.04,81.94c-0.29,1.29-0.43,2.67-0.43,4.16c0,0.23,0.01,0.43,0.04,0.6c0.03,0.17,0.04,0.34,0.04,0.52h5.4l-6.17,35.07c2.06,0.34,3.97,0.52,5.75,0.52c1.94,0,4-0.17,6.17-0.52l7.8-44.33H76.33C75.76,79.32,75.33,80.65,75.04,81.94z"/>
												<path class="logo-letras" d="M96.99,59.09c-0.97-0.23-2.02-0.39-3.13-0.47c-1.11-0.08-2.13-0.13-3.04-0.13c-0.92,0-1.94,0.04-3.09,0.13c-1.14,0.09-2.23,0.24-3.26,0.47c-0.69,2-1.19,3.9-1.5,5.7c-0.32,1.8-0.44,3.7-0.39,5.7c0.91,0.17,1.94,0.29,3.09,0.34c1.14,0.06,2.14,0.09,3,0.09c0.91,0,1.93-0.03,3.04-0.09c1.12-0.06,2.19-0.17,3.22-0.34c0.69-1.94,1.2-3.83,1.54-5.66C96.82,63.01,96.99,61.09,96.99,59.09z"/>
												<path class="logo-letras" d="M121.6,76.92c-4.17,0-7.84,0.86-11.02,2.57c-3.17,1.71-5.84,3.93-8.02,6.64c-2.17,2.72-3.82,5.77-4.93,9.17c-1.12,3.4-1.67,6.79-1.67,10.16c0,5.54,1.51,9.9,4.54,13.08c3.03,3.17,7.8,4.76,14.32,4.76c2.46,0,4.72-0.17,6.77-0.51c2.06-0.34,4-0.91,5.83-1.71c0-2.34-0.2-4.23-0.6-5.66c-0.4-1.43-0.92-2.66-1.54-3.69c-1.83,0.74-3.36,1.23-4.59,1.46c-1.23,0.23-2.47,0.34-3.73,0.34c-2.46,0-4.49-0.74-6.09-2.23c-1.6-1.48-2.4-3.8-2.4-6.95c0-2.29,0.27-4.49,0.81-6.6c0.54-2.11,1.37-3.99,2.49-5.62c1.12-1.63,2.5-2.94,4.16-3.95c1.66-1,3.6-1.5,5.83-1.5c1.49,0,2.84,0.14,4.07,0.43c1.23,0.29,2.47,0.69,3.73,1.2c0.97-1.54,1.69-3.16,2.14-4.84c0.46-1.69,0.71-3.27,0.77-4.76c-1.66-0.63-3.4-1.08-5.23-1.37C125.43,77.07,123.54,76.92,121.6,76.92z"/>
												<path class="logo-letras" d="M171,77.44c-1.14,0-2.24,0.03-3.3,0.09c-1.06,0.06-2.19,0.2-3.39,0.43c-0.06,0.92-0.37,2.14-0.94,3.69c-0.57,1.54-1.69,3.4-3.34,5.57l-9,11.83l8.15,23.23c1.14,0.17,2.2,0.29,3.17,0.34c0.97,0.06,2,0.09,3.09,0.09c1.03,0,2.04-0.04,3.04-0.13c1-0.09,2.1-0.19,3.3-0.3l-8.32-23.15l8.66-10.8c1.66-2.34,2.93-4.29,3.82-5.83c0.89-1.54,1.41-3.06,1.59-4.54c-0.97-0.17-2.04-0.3-3.21-0.39C173.13,77.48,172.03,77.44,171,77.44z"/>
												<path class="logo-letras" d="M155.06,62.86c0-1.31-0.14-2.4-0.43-3.26c-2-0.34-3.83-0.51-5.49-0.51c-0.91,0-2,0.04-3.26,0.13c-1.26,0.09-2.37,0.21-3.34,0.39c0.06,0.51,0.1,0.99,0.13,1.41c0.03,0.43,0.04,0.96,0.04,1.59c0,3.09-0.51,7.63-1.54,13.63l-8.06,46.04c1.94,0.34,3.89,0.52,5.83,0.52c2.11,0,4.2-0.17,6.26-0.52l8.83-50.24C154.71,68.43,155.06,65.38,155.06,62.86z"/>
												<path class="logo-letras" d="M232.42,77.95c0,0.17,0.01,0.37,0.04,0.6c0.03,0.23,0.04,0.49,0.04,0.77c0,1.14-0.17,2.57-0.51,4.29c-0.34,1.71-1,3.69-1.97,5.92l-8.32,19.29l-2.4-30.87c-2.06-0.34-4.14-0.51-6.26-0.51c-2.12,0-4.06,0.17-5.83,0.51l-12.78,30.78l-1.2-30.78c-0.97-0.23-1.96-0.37-2.96-0.43c-1-0.06-1.99-0.09-2.96-0.09c-2.46,0-4.8,0.17-7.03,0.51l4.54,44.33c0.91,0.17,1.91,0.3,3,0.39c1.08,0.09,2.11,0.13,3.09,0.13c1.14,0,2.32-0.06,3.52-0.17c1.2-0.12,2.34-0.23,3.43-0.34l12.09-28.21l2.49,28.21c1.89,0.34,3.86,0.52,5.92,0.52c1.14,0,2.36-0.04,3.64-0.13c1.29-0.09,2.44-0.21,3.47-0.39l15.95-31.12c1.43-2.74,2.46-5.12,3.09-7.12c0.63-2,0.94-3.91,0.94-5.74v-0.34c-2-0.34-4.17-0.51-6.52-0.51C236.48,77.44,234.31,77.61,232.42,77.95z"/>
												<path class="logo-letras" d="M279.59,79.71c-1.2-0.94-2.62-1.64-4.24-2.1c-1.63-0.46-3.39-0.69-5.27-0.69c-3.94,0-7.5,0.81-10.67,2.44c-3.17,1.63-5.86,3.77-8.06,6.43c-2.2,2.66-3.9,5.67-5.1,9.05c-1.2,3.37-1.8,6.8-1.8,10.29c0,2.74,0.39,5.25,1.16,7.5c0.77,2.26,1.97,4.17,3.6,5.74c1.63,1.57,3.69,2.79,6.17,3.64c2.49,0.86,5.47,1.29,8.96,1.29c1.08,0,2.31-0.07,3.69-0.21c1.37-0.14,2.74-0.34,4.12-0.6c1.37-0.26,2.7-0.57,3.99-0.94c1.29-0.37,2.41-0.79,3.39-1.24c0-1.83-0.16-3.56-0.47-5.19c-0.32-1.63-0.93-3.02-1.84-4.16c-1.94,0.8-3.79,1.44-5.53,1.93c-1.74,0.49-3.76,0.73-6.04,0.73c-2.86,0-5.03-0.67-6.52-2.01c-1.49-1.34-2.4-3.39-2.74-6.13l5.75-0.94c2.74-0.4,5.39-1.01,7.93-1.84c2.54-0.83,4.81-1.9,6.82-3.21c2-1.31,3.6-2.91,4.8-4.8c1.2-1.89,1.8-4.12,1.8-6.69c0-1.83-0.34-3.43-1.03-4.8C281.73,81.81,280.79,80.65,279.59,79.71z M271.44,91.58c-0.29,0.69-0.83,1.36-1.63,2.02c-0.8,0.66-1.89,1.26-3.26,1.8c-1.37,0.54-3.14,0.99-5.32,1.33l-4.46,0.69c0.34-1.43,0.84-2.84,1.5-4.24c0.66-1.4,1.44-2.64,2.36-3.73c0.91-1.09,1.99-1.96,3.22-2.62c1.23-0.66,2.58-0.99,4.07-0.99c1.2,0,2.16,0.34,2.87,1.03c0.71,0.69,1.07,1.57,1.07,2.66C271.87,90.21,271.73,90.9,271.44,91.58z"/>
												<path class="logo-letras" d="M327.29,81.04c-2.14-2.74-5.22-4.12-9.22-4.12c-1.89,0-3.54,0.2-4.97,0.6c-1.43,0.4-2.69,0.94-3.77,1.63c-1.09,0.69-2.04,1.44-2.87,2.27c-0.83,0.83-1.59,1.67-2.27,2.53l2.14-11.92c0.69-3.6,1.03-6.66,1.03-9.17c0-1.31-0.14-2.4-0.43-3.26c-0.05-0.01-0.1-0.01-0.15-0.02c-3.37,2.57-7.41,4.28-11.82,4.84c-0.15,2.96-0.64,6.89-1.49,11.81l-7.89,44.5c2,0.8,4.12,1.43,6.34,1.89c2.23,0.46,4.69,0.69,7.37,0.69c5.89,0,10.83-0.91,14.83-2.74c4-1.83,7.22-4.2,9.65-7.12c2.43-2.92,4.16-6.17,5.19-9.78c1.03-3.6,1.54-7.17,1.54-10.72C330.5,87.76,329.43,83.78,327.29,81.04z M316.57,101.02c-0.54,2.17-1.4,4.16-2.57,5.96c-1.17,1.8-2.66,3.29-4.46,4.46c-1.8,1.17-3.96,1.76-6.47,1.76c-0.74,0-1.47-0.04-2.19-0.13c-0.71-0.09-1.3-0.21-1.76-0.38l1.89-10.97c0.86-5.14,2.23-8.83,4.12-11.06c1.89-2.23,4.14-3.34,6.77-3.34c2,0,3.41,0.73,4.24,2.19c0.83,1.46,1.24,3.19,1.24,5.19C317.38,96.73,317.11,98.84,316.57,101.02z"/>
											</svg>
										</div>
									</a>
									<span class="version-project">- {$_versao}</span>
								</div>
							</div>
						</footer>
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
