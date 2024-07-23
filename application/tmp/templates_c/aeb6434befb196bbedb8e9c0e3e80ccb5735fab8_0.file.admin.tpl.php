<?php
/* Smarty version 3.1.36, created on 2024-07-22 22:02:53
  from 'c:\xampp-7.4\htdocs\admin.gazetamarista.com.br\application\layouts\admin.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_669f013d6b1553_05153898',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'aeb6434befb196bbedb8e9c0e3e80ccb5735fab8' => 
    array (
      0 => 'c:\\xampp-7.4\\htdocs\\admin.gazetamarista.com.br\\application\\layouts\\admin.tpl',
      1 => 1721476787,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_669f013d6b1553_05153898 (Smarty_Internal_Template $_smarty_tpl) {
?><!doctype html>
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
		<link rel="shortcut icon" type="image/png" href="<?php echo $_smarty_tpl->tpl_vars['imagePath']->value;?>
/favicon/32x32.png">

		<!-- Favicon Apple -->
		<link rel="apple-touch-icon" sizes="57x57" href="<?php echo $_smarty_tpl->tpl_vars['imagePath']->value;?>
/favicon/57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="<?php echo $_smarty_tpl->tpl_vars['imagePath']->value;?>
/favicon/60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="<?php echo $_smarty_tpl->tpl_vars['imagePath']->value;?>
/favicon/72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="<?php echo $_smarty_tpl->tpl_vars['imagePath']->value;?>
/favicon/76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="<?php echo $_smarty_tpl->tpl_vars['imagePath']->value;?>
/favicon/114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="<?php echo $_smarty_tpl->tpl_vars['imagePath']->value;?>
/favicon/120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="<?php echo $_smarty_tpl->tpl_vars['imagePath']->value;?>
/favicon/144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="<?php echo $_smarty_tpl->tpl_vars['imagePath']->value;?>
/favicon/152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $_smarty_tpl->tpl_vars['imagePath']->value;?>
/favicon/180x180.png">

		<!-- Outros Favicons -->
		<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo $_smarty_tpl->tpl_vars['imagePath']->value;?>
/favicon/192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="<?php echo $_smarty_tpl->tpl_vars['imagePath']->value;?>
/favicon/32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="<?php echo $_smarty_tpl->tpl_vars['imagePath']->value;?>
/favicon/96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $_smarty_tpl->tpl_vars['imagePath']->value;?>
/favicon/16x16.png">

		<!-- Splash Screen PWA -->
		<link href="<?php echo $_smarty_tpl->tpl_vars['imagePath']->value;?>
/splashscreens/iphone5_splash.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
		<link href="<?php echo $_smarty_tpl->tpl_vars['imagePath']->value;?>
/splashscreens/iphone6_splash.png" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
		<link href="<?php echo $_smarty_tpl->tpl_vars['imagePath']->value;?>
/splashscreens/iphoneplus_splash.png" media="(device-width: 621px) and (device-height: 1104px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
		<link href="<?php echo $_smarty_tpl->tpl_vars['imagePath']->value;?>
/splashscreens/iphonex_splash.png" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
		<link href="<?php echo $_smarty_tpl->tpl_vars['imagePath']->value;?>
/splashscreens/iphonexr_splash.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
		<link href="<?php echo $_smarty_tpl->tpl_vars['imagePath']->value;?>
/splashscreens/iphonexsmax_splash.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
		<link href="<?php echo $_smarty_tpl->tpl_vars['imagePath']->value;?>
/splashscreens/ipad_splash.png" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
		<link href="<?php echo $_smarty_tpl->tpl_vars['imagePath']->value;?>
/splashscreens/ipadpro1_splash.png" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
		<link href="<?php echo $_smarty_tpl->tpl_vars['imagePath']->value;?>
/splashscreens/ipadpro3_splash.png" media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
		<link href="<?php echo $_smarty_tpl->tpl_vars['imagePath']->value;?>
/splashscreens/ipadpro2_splash.png" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />

		<!-- Manifest PWA -->
		<link rel="manifest" href="<?php echo $_smarty_tpl->tpl_vars['imagePath']->value;?>
/favicon/site_manifest.json">

		<!-- Outras informações PWA -->
		<link rel="mask-icon" href="<?php echo $_smarty_tpl->tpl_vars['imagePath']->value;?>
/favicon/safari-pinned-tab.svg" color="#d33535">
		<meta name="apple-mobile-web-app-title" content="CW Panel">
		<meta name="application-name" content="CW Panel">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="theme-color" content="#ffffff">
		<meta name="msapplication-TileImage" content="<?php echo $_smarty_tpl->tpl_vars['imagePath']->value;?>
/favicon/180x180.png">

		<?php echo $_smarty_tpl->tpl_vars['this']->value->headTitle();?>

		<?php echo $_smarty_tpl->tpl_vars['this']->value->headMeta();?>

		<?php echo $_smarty_tpl->tpl_vars['this']->value->headLink();?>


		<link type="text/css" rel="stylesheet" media="print" href="<?php echo $_smarty_tpl->tpl_vars['basePath']->value;?>
/common/admin/css/impressaogeral.css">

		<!--[if lt IE 9]>
			<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['basePath']->value;?>
common/default/js/ie8.js" type="text/javascript"><?php echo '</script'; ?>
>
		<![endif]-->

		<?php echo '<script'; ?>
>
			document.basePath = '<?php echo $_smarty_tpl->tpl_vars['basePath']->value;?>
';
			document.openedController = '<?php echo $_smarty_tpl->tpl_vars['openedController']->value;?>
';
			document.nomeUser = '<?php echo $_smarty_tpl->tpl_vars['logged_usuario']->value["nome"];?>
';

			var _GLOBALS = window._GLOBALS = {
				basePath: '<?php echo $_smarty_tpl->tpl_vars['basePath']->value;?>
',
				imagePath: '<?php echo $_smarty_tpl->tpl_vars['imagePath']->value;?>
',
				currentModule: '<?php echo $_smarty_tpl->tpl_vars['currentModule']->value;?>
',
				currentController: '<?php echo $_smarty_tpl->tpl_vars['currentController']->value;?>
',
				currentAction: '<?php echo $_smarty_tpl->tpl_vars['currentAction']->value;?>
',
				permitidoAdicionar: "<?php echo $_smarty_tpl->tpl_vars['_permitidoAdicionar']->value;?>
",
				permitidoEditar: "<?php echo $_smarty_tpl->tpl_vars['_permitidoEditar']->value;?>
",
				permitidoExcluir: "<?php echo $_smarty_tpl->tpl_vars['_permitidoExcluir']->value;?>
",
				permitidoVisulizar: "<?php echo $_smarty_tpl->tpl_vars['_permitidoVisulizar']->value;?>
"
			};
		<?php echo '</script'; ?>
>
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
						<?php echo $_smarty_tpl->tpl_vars['this']->value->navigation()->menu();?>

					</div>
				</aside>
				<div class="row collapse">
					<div class="medium-2 columns show-for-medium-up menu-navegacao-off-left">
						<div class="icon-bar vertical one-up">

							<a class="logo-usuario small-9 medium-5 large-6 columns left small-only-text-center title-project">
								
								<?php if ($_smarty_tpl->tpl_vars['logged_usuario']->value["avatar"]) {?>
									<img src="<?php echo $_smarty_tpl->tpl_vars['basePath']->value;?>
/common/uploads/usuarios/<?php echo $_smarty_tpl->tpl_vars['logged_usuario']->value["avatar"];?>
" alt="Usuário"/>
								<?php } else { ?>
									<img src="<?php echo $_smarty_tpl->tpl_vars['basePath']->value;?>
/common/uploads/usuarios/default.png" alt="Usuário"/>
								<?php }?>

								<?php if ($_smarty_tpl->tpl_vars['logged_usuario']->value["nome"]) {?>
									<h1 class="titulo-usuario"><?php echo implode(' ',array_slice(explode(' ',$_smarty_tpl->tpl_vars['logged_usuario']->value["nome"]),0,2));?>
</h1>
								<?php } else { ?>
									<h1 class="titulo-usuario">Usuário Anônimo</h1>
								<?php }?>
							</a>

							<?php echo $_smarty_tpl->tpl_vars['this']->value->navigation()->menu();?>


							<div class="btnsPrincipais">
								<a class="BtnLogout" href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url(array('module'=>'admin','controller'=>'usuarios','action'=>'logout'),'default',TRUE);?>
">
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

							<?php if ($_smarty_tpl->tpl_vars['currentController']->value != 'index') {?>
								<div class="row sub_header" >
									<div class="small-12 columns">
										<?php echo $_smarty_tpl->tpl_vars['this']->value->navigation()->breadcrumbs()->setLinkLast(TRUE)->setSeparator(' - ')->setMinDepth(-1)->setPartial(array('breadcrumbs.tpl','admin'));?>

									</div>
								</div>
							<?php } else { ?>
								<div class="row sub_header" >
									<div class="small-12 columns">
										<ul class="breadcrumbs">
											<li class="unavailable">Dashboard</li>
										</ul>
										<h2 style="text-transform: capitalize;">Dashboard</h2>

									</div>
								</div>
							<?php }?>
						</header>

						<main id="site-corpo" class="pagina-<?php echo $_smarty_tpl->tpl_vars['currentAction']->value;?>
">
							<?php echo $_smarty_tpl->tpl_vars['this']->value->layout()->content;?>

						</main>
					</div>
				</div>
				<a class="menu-principal-off-overlay"></a>
			</div>
		</div>
		<!-- Final do Menu off-canvas -->

		<?php echo $_smarty_tpl->tpl_vars['this']->value->headScript();?>


		<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support -->
  		<?php echo '<script'; ?>
 src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"><?php echo '</script'; ?>
>

		<!-- Obrigatório em todas as páginas -->
		
			<?php echo '<script'; ?>
 type="text/javascript">
				/**
				* Foundation
				**/
				$(document).foundation();
			<?php echo '</script'; ?>
>
		

		<?php echo '<script'; ?>
 type="text/javascript">
			<?php if ((($tmp = @$_smarty_tpl->tpl_vars['success']->value)===null||$tmp==='' ? '' : $tmp) != '') {?>
				<?php $_smarty_tpl->_assignInScope('timer_seconds', 2500);?>
				<?php if (mb_strlen($_smarty_tpl->tpl_vars['success']->value, 'UTF-8') > 40) {
$_smarty_tpl->_assignInScope('timer_seconds', 5000);
}?>
				<?php if (mb_strlen($_smarty_tpl->tpl_vars['success']->value, 'UTF-8') > 60) {
$_smarty_tpl->_assignInScope('timer_seconds', 7000);
}?>
				swal({
				  title: "Sucesso!",
				  text: "<?php echo $_smarty_tpl->tpl_vars['success']->value;?>
",
				  type: "success",
				  showConfirmButton: false,
				  timer: <?php echo $_smarty_tpl->tpl_vars['timer_seconds']->value;?>
,
				  onOpen: () => {
				    swal.showLoading()
				  }
				});
            <?php }?>
            <?php if ((($tmp = @$_smarty_tpl->tpl_vars['error']->value)===null||$tmp==='' ? '' : $tmp) != '') {?>
                swal({
				  title: "Ops!",
				  text: "<?php echo $_smarty_tpl->tpl_vars['error']->value;?>
",
				  type: "error",
				  showConfirmButton: true
				});
            <?php }?>
    	<?php echo '</script'; ?>
>

	</body>
</html>
<?php }
}
