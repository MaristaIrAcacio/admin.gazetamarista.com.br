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
	<meta name="robots" content="noindex, nofollow">	

	{$this->headTitle()}
	{$this->headMeta()}
	{$this->headLink()}

	<link type="text/css" rel="stylesheet" media="print" href="{$basePath}/common/admin/css/impressaogeral.css">

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

	<script type="application/ld+json">
		{
		"@context": "https://schema.org",
		"@type": "WebApplication",
		"name": "Painel Admin do Projeto Gazeta Marista",
		"description": "Painel administrativo para gerenciamento do web jornal Gazeta Marista do Marista Escola Social Irmão Acácio.",
		"applicationCategory": "BusinessApplication",
		"operatingSystem": "All",
		"url": "{$basePath}",
		"author": {
			"@type": "Person",
			"name": "Vitor Gabriel de Oliveira"
		}
		"version": "1.0.0",
		"datePublished": "2024-08-07"
		}
	</script>
	

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.4.47/css/materialdesignicons.min.css" integrity="sha512-/k658G6UsCvbkGRB3vPXpsPHgWeduJwiWGPCGS14IQw3xpr63AEMdA8nMYG2gmYkXitQxDTn6iiK/2fD4T87qA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	
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
											<li class="unavailable">Dashboard | Jornal e Rádio</li>
										</ul>
									</div>
								</div>
							{/if}
						</header>

						<main id="site-corpo" class="pagina-{$currentAction}">
							{$this->layout()->content}
						</main>
					</div>
					<div class="medium-2 columns show-for-medium-up menu-navegacao-off-left">
						<div class="icon-bar vertical one-up">

							<a href="{$this->url(['module'=>'admin', 'controller'=>'index', 'action'=>'index'], 'default', TRUE)}" class="logo-usuario small-9 medium-5 large-6 columns left small-only-text-center title-project">
								
								{if $logged_usuario["avatar"] && file_exists({$basePath}/common/uploads/usuarios/{$logged_usuario["avatar"]}) }
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

							{if $logged_usuario["idperfil"] > 2}
								<ul class="off-canvas-list" style="padding-bottom: 0;">
									<li>
										<a href="#"> <div class="icone_menu_principal mdi mdi-bell-alert"></div>
											Notificações
											<span class="notify-categoria-add">+{$_countNotif}</span>
										</a>
										<ul>
										
										{if $_NotifMateria|count < 1 && $_NotifCharge|count < 1 && $_NotifPauta|count < 1}
										<li>
											<a>
												Não há notificações
											</a>
										</li>
										{/if}

										{if $_NotifMateria|count > 0}
											<li>
												<a href="{$basePath}/admin/materiaspendente/list">
													Nova{if $_NotifMateria|count > 1}s{/if} Matéria{if $_NotifMateria|count > 1}s{/if} |
													<span class="notify-span">+{$_NotifMateria|count}</span>
												</a>
											</li>
										{/if}

										{if $_NotifCharge|count > 0}
											<li>
												<a href="{$basePath}/admin/chargespendente/list">
													Nova{if $_NotifCharge|count > 1}s{/if} Charge{if $_NotifCharge|count > 1}s{/if} |
													<span class="notify-span">+{$_NotifCharge|count}</span>
												</a>
											</li>
										{/if}

										{if $_NotifPauta|count > 0}
											<li>
												<a href="{$basePath}/admin/radio/list">
													Nova{if $_NotifPauta|count > 1}s{/if} Pauta{if $_NotifPauta|count > 1}s{/if} |
													<span class="notify-span">+{$_NotifPauta|count}</span>
												</a>
											</li>
										{/if}
										</ul>
									</li>
								</ul>
							{/if}

							{$this->navigation()->menu()}

							<ul class="off-canvas-list off-canva-log" style="padding-bottom: 0;">
								<li>
									<a href="{$this->url(['module'=>'admin', 'controller'=>'usuarios', 'action'=>'logout'], 'default', TRUE)}"> <div class="icone_menu_principal mdi mdi-logout"></div>
										Sair
									</a>
								</li>
							</ul>
						</div>
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
