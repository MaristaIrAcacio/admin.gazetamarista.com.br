<?php
/* Smarty version 3.1.36, created on 2024-07-19 21:10:00
  from 'c:\xampp-7.4\htdocs\rkadvisors.com.br\application\layouts\default.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_669b0058a6bf22_16916666',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '84bc6ebd38e7403196fc3e42b613a15f19ee05f9' => 
    array (
      0 => 'c:\\xampp-7.4\\htdocs\\rkadvisors.com.br\\application\\layouts\\default.tpl',
      1 => 1721433700,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:default/geral/topo.tpl' => 1,
    'file:default/geral/rodape.tpl' => 1,
    'file:default/geral/cookies.tpl' => 1,
  ),
),false)) {
function content_669b0058a6bf22_16916666 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<!--
		░█████╗░██╗░░░░░██╗░█████╗░██╗░░██╗░██╗░░░░░░░██╗███████╗██████╗░
		██╔══██╗██║░░░░░██║██╔══██╗██║░██╔╝░██║░░██╗░░██║██╔════╝██╔══██╗
		██║░░╚═╝██║░░░░░██║██║░░╚═╝█████═╝░░╚██╗████╗██╔╝█████╗░░██████╦╝
		██║░░██╗██║░░░░░██║██║░░██╗██╔═██╗░░░████╔═████║░██╔══╝░░██╔══██╗
		╚█████╔╝███████╗██║╚█████╔╝██║░╚██╗░░╚██╔╝░╚██╔╝░███████╗██████╦╝
		░╚════╝░╚══════╝╚═╝░╚════╝░╚═╝░░╚═╝░░░╚═╝░░░╚═╝░░╚══════╝╚═════╝░
		Autor: 𝘊𝘭𝘪𝘤𝘬𝘸𝘦𝘣
		Ano: 2023
		Site: https://gazetamarista.com.br/
		Contato: https://encurtador.com.br/cxPQZ
		-->
		<base href="<?php echo $_smarty_tpl->tpl_vars['basePath']->value;?>
/" />
		<meta charset="UTF-8" />
		<?php echo $_smarty_tpl->tpl_vars['this']->value->headTitle();?>
 <?php echo $_smarty_tpl->tpl_vars['this']->value->headMeta();?>


		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta
			name="viewport"
			content="width=device-width, initial-scale=1.0, user-scalable=no"
		/>
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="mobile-web-app-capable" content="yes" />
		<meta
			name="apple-mobile-web-app-status-bar-style"
			content="black-translucent"
		/>
		<meta name="format-detection" content="telephone=no" />
		<meta name="msapplication-tap-highlight" content="no" />

		<?php echo $_smarty_tpl->tpl_vars['this']->value->headLink();?>


		<link
			rel="shortcut icon"
			type="image/png"
			href="<?php echo $_smarty_tpl->tpl_vars['basePath']->value;?>
/common/default/images/favicon/32x32.png"
		/>

		<meta name="application-name" content="" />
		<meta name="msapplication-TileColor" content="#ffffff" />
		<meta name="msapplication-config" content="none" />

		<?php echo '<script'; ?>
>
			var _GLOBALS = (window._GLOBALS = {
				basePath: "<?php echo $_smarty_tpl->tpl_vars['basePath']->value;?>
",
				currentModule: "<?php echo $_smarty_tpl->tpl_vars['currentModule']->value;?>
",
				currentController: "<?php echo $_smarty_tpl->tpl_vars['currentController']->value;?>
",
				currentAction: "<?php echo $_smarty_tpl->tpl_vars['currentAction']->value;?>
",
				recaptcha_key: "<?php echo $_smarty_tpl->tpl_vars['_configuracao']->value->recaptcha_key;?>
",
			});
		<?php echo '</script'; ?>
>

		<!-- Compartilhamento -->
		<meta property="og:locale" content="pt_BR" />
		<meta
			property="og:site_name"
			content="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['_configuracao']->value->nome_site, ENT_QUOTES, 'UTF-8', true);?>
"
		/>
		<meta
			property="og:type"
			content="<?php echo $_smarty_tpl->tpl_vars['og_arr']->value['titulo'] ? 'article' : 'website';?>
"
		/>
		<?php if (!empty($_smarty_tpl->tpl_vars['og_arr']->value['url'])) {?>
		<meta property="og:url" content="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['og_arr']->value['url'], ENT_QUOTES, 'UTF-8', true);?>
" />
		<?php } else { ?>
		<meta property="og:url" content="<?php echo current_url();?>
" />
		<?php }?> <?php if (!empty($_smarty_tpl->tpl_vars['og_arr']->value['titulo'])) {?>
		<meta property="og:title" content="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['og_arr']->value['titulo'], ENT_QUOTES, 'UTF-8', true);?>
" />
		<?php } else { ?>
		<meta property="og:title" content="<?php echo strip_tags($_smarty_tpl->tpl_vars['this']->value->headTitle());?>
" />
		<?php }?> <?php if (!empty($_smarty_tpl->tpl_vars['og_arr']->value['descricao'])) {?>
		<meta property="og:description" content="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['og_arr']->value['descricao'], ENT_QUOTES, 'UTF-8', true);?>
" />
		<?php } else { ?>
		<meta
			property="og:description"
			content="<?php echo strip_tags($_smarty_tpl->tpl_vars['this']->value->headMeta()->getValue('description')->content);?>
"
		/>
		<?php }?> <?php if (!empty($_smarty_tpl->tpl_vars['og_arr']->value['imagem'])) {?>
		<meta property="og:image" content="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['og_arr']->value['imagem'], ENT_QUOTES, 'UTF-8', true);?>
" />
		<?php } else { ?>
		<?php }?> <?php if ($_smarty_tpl->tpl_vars['application_env']->value == 'production') {?>
		<!-- Código final head -->
		<?php echo $_smarty_tpl->tpl_vars['_configuracao']->value->codigo_final_head;?>
 <?php }?>
	</head>

	<body class="page-<?php echo $_smarty_tpl->tpl_vars['currentController']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['currentAction']->value;?>
">
		<?php if ($_smarty_tpl->tpl_vars['application_env']->value == 'production') {?>
		<!-- Código início do body -->
		<?php echo $_smarty_tpl->tpl_vars['_configuracao']->value->codigo_inicio_body;?>
 <?php }?>

		<!-- Topo -->
		<?php $_smarty_tpl->_subTemplateRender("file:default/geral/topo.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

		<!-- Conteúdo -->
		<?php echo $_smarty_tpl->tpl_vars['this']->value->layout()->content;?>


		<!-- Rodapé -->
		<?php $_smarty_tpl->_subTemplateRender("file:default/geral/rodape.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

		<!-- Cookies -->
		<?php $_smarty_tpl->_subTemplateRender("file:default/geral/cookies.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

		<!-- Scripts iniciais -->
		<?php echo $_smarty_tpl->tpl_vars['this']->value->headScript();?>
 <?php if ($_smarty_tpl->tpl_vars['application_env']->value == 'production') {?>
		<!-- Código final do body -->
		<?php echo $_smarty_tpl->tpl_vars['_configuracao']->value->codigo_final_body;?>
 <?php }?>

		<!-- Alerta padrão -->
		<?php if ((($tmp = @$_smarty_tpl->tpl_vars['success']->value)===null||$tmp==='' ? '' : $tmp) != '') {?>
		<?php echo '<script'; ?>
 type="text/javascript">
			Swal.fire({
				title: "Sucesso!",
				text: "<?php echo $_smarty_tpl->tpl_vars['success']->value;?>
",
				type: "success",
				showConfirmButton: false,
				timer: 3000,
				onOpen: () => {
					Swal.showLoading();
				},
			});
		<?php echo '</script'; ?>
>
		<?php }?> <?php if ((($tmp = @$_smarty_tpl->tpl_vars['error']->value)===null||$tmp==='' ? '' : $tmp) != '') {?>
		<?php echo '<script'; ?>
 type="text/javascript">
			Swal.fire("Ops!", "<?php echo $_smarty_tpl->tpl_vars['error']->value;?>
", "error");
		<?php echo '</script'; ?>
>
		<?php }?> <?php if ((($tmp = @$_smarty_tpl->tpl_vars['warning']->value)===null||$tmp==='' ? '' : $tmp) != '') {?>
		<?php echo '<script'; ?>
 type="text/javascript">
			Swal.fire("Ops!", "<?php echo $_smarty_tpl->tpl_vars['warning']->value;?>
", "warning");
		<?php echo '</script'; ?>
>
		<?php }?>
	</body>
</html>
<?php }
}
