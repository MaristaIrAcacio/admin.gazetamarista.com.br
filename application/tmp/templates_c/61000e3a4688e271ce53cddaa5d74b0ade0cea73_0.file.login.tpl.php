<?php
/* Smarty version 3.1.36, created on 2024-07-22 21:03:22
  from 'c:\xampp-7.4\htdocs\admin.gazetamarista.com.br\application\modules\admin\views\usuarios\login.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_669ef34adcef72_75076662',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '61000e3a4688e271ce53cddaa5d74b0ade0cea73' => 
    array (
      0 => 'c:\\xampp-7.4\\htdocs\\admin.gazetamarista.com.br\\application\\modules\\admin\\views\\usuarios\\login.tpl',
      1 => 1721437761,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_669ef34adcef72_75076662 (Smarty_Internal_Template $_smarty_tpl) {
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

		
			<!-- https://browser-update.org/pt/ -->
			<?php echo '<script'; ?>
>
				var $buoop = {required:{e:-3,f:-3,o:-3,s:-3,c:-3},insecure:true,style:"bottom",api:2019.10 };
				function $buo_f() {
 					var e = document.createElement("script");
					e.src = "//browser-update.org/update.min.js";
 					document.body.appendChild(e);
				};
				try { document.addEventListener("DOMContentLoaded", $buo_f,false) }
					catch(e){window.attachEvent("onload", $buo_f)}
			<?php echo '</script'; ?>
>
		
	</head>
	
	<body>
		<main id="site-corpo" class="pagina-<?php echo $_smarty_tpl->tpl_vars['currentAction']->value;?>
">
			<div class="small-12 medium-4 large-4 columns formulario">
				<div class="box">
					<div class="image">
						<img src="<?php echo $_smarty_tpl->tpl_vars['basePath']->value;?>
/common/admin/images/logos/logo-marista.png" alt="">
					</div>
					<form enctype="application/x-www-form-urlencoded" action="<?php echo $_smarty_tpl->tpl_vars['this']->value->CreateUrl('login','usuarios','admin',array(),TRUE);?>
" method="post" data-abide>
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
				swal({
				  title: "Sucesso!",
				  text: "<?php echo $_smarty_tpl->tpl_vars['success']->value;?>
",
				  type: "success",
				  showConfirmButton: false,
				  timer: 2000,
				  onOpen: () => {
				    swal.showLoading()
				  }
				});
            <?php }?>
            <?php if ((($tmp = @$_smarty_tpl->tpl_vars['error']->value)===null||$tmp==='' ? '' : $tmp) != '') {?>
                swal('Ops!', '<?php echo $_smarty_tpl->tpl_vars['error']->value;?>
', 'error');
            <?php }?>
    	<?php echo '</script'; ?>
>

	</body>
</html>
<?php }
}
