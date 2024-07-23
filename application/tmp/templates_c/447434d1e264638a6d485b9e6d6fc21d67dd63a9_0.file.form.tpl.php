<?php
/* Smarty version 3.1.36, created on 2024-07-23 08:46:34
  from 'c:\xampp-7.4\htdocs\admin.gazetamarista.com.br\application\modules\admin\views\configuracoes\form.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_669f981a6214b4_31875365',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '447434d1e264638a6d485b9e6d6fc21d67dd63a9' => 
    array (
      0 => 'c:\\xampp-7.4\\htdocs\\admin.gazetamarista.com.br\\application\\modules\\admin\\views\\configuracoes\\form.tpl',
      1 => 1721729699,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_669f981a6214b4_31875365 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="row">
	<div class="small-12 columns buttons-bar">
		<ul class="stack-for-small button-group">
			<li>					
				<button form="form_admin" type="submit" name="submitcontinuar" value="true" onclick="$('#'+this.getAttribute('form')).submit();">
					<span class="mdi mdi-content-save-move-outline"></span> Atualizar informações
				</button>
			</li>
		</ul>
		<p class="cleafix show-for-small-only"></p>
	</div>
	<form enctype="multipart/form-data" id="form_admin" action="<?php echo $_smarty_tpl->tpl_vars['form']->value->getAction();?>
" method="post" data-abide>
		<div class="small-12 columns">
			<div class="show-for-medium-up">
				<ul class="tabs" data-tab data-options="deep_linking:true">
					<li class="tab-title active"><a href="#geral">Geral</a></li>
					<?php if ($_smarty_tpl->tpl_vars['idperfil']->value === '99') {?><li class="tab-title"><a href="#codigos">Códigos/Share</a></li><?php }?>
					<li class="tab-title"><a href="#cookies">Política Cookies</a></li>
				</ul>
			</div>
			<div class="show-for-small-only">
				<nav class="top-bar" data-topbar role="navigation">
					<ul class="title-area">
						<li class="name">
						</li>
						<li class="toggle-topbar menu-icon">
							<a href="#"><span></span></a>
						</li>
					</ul>
					<section class="top-bar-section">
						<ul class="left" data-tab data-options="deep_linking:true">
							<li class="active"><a href="#geral">Geral</a></li>
							<?php if ($_smarty_tpl->tpl_vars['idperfil']->value === '99') {?><li><a href="#codigos">Códigos/Share</a></li><?php }?>
							<li><a href="#cookies">Política Cookies</a></li>
						</ul>
					</section>
				</nav>
			</div>
			<div class="tabs-content">
				<div class="content active" id="geral">
					<input id="idconfiguracao" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['idconfiguracao']->value;?>
">
					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('nome_site');?>

					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('email_rodape');?>

					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('email_contato');?>

					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('facebook');?>

					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('instagram');?>

					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('linkedin');?>

					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('whatsapp');?>

					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('twitter');?>

					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('cidade_rodape');?>

				</div>

				<div class="content" id="codigos">
					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('recaptcha_key');?>

					<br>
					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('recaptcha_secret');?>

					<br>
					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('share_tag');?>

					<br>
					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('codigo_final_head');?>

					<br>
					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('codigo_inicio_body');?>

					<br>
					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('codigo_final_body');?>

				</div>

				<div class="content" id="cookies">
					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('politica_cookie_texto');?>

				</div>
			</div>
		</div>
	</form>
</div>
<?php }
}
