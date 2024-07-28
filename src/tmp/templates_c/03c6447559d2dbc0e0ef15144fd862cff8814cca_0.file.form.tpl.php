<?php
/* Smarty version 3.1.36, created on 2024-07-27 17:12:07
  from 'c:\xampp-7.4\htdocs\admin.gazetamarista.com.br\application\modules\admin\views\radioafter\form.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_66a554974a61c6_18573167',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '03c6447559d2dbc0e0ef15144fd862cff8814cca' => 
    array (
      0 => 'c:\\xampp-7.4\\htdocs\\admin.gazetamarista.com.br\\application\\modules\\admin\\views\\radioafter\\form.tpl',
      1 => 1722045967,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_66a554974a61c6_18573167 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="row">
	<div class="small-12 columns buttons-bar">
		<ul class="stack-for-small button-group">
			<li>
				<a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url(array('module'=>'admin','controller'=>$_smarty_tpl->tpl_vars['controller']->value,'action'=>'list'),'default',TRUE);?>
" class="button alert" id="cancel">
					<span class="mdi mdi-backburger"></span> Visualizar pautas
				</a>
			</li>
			<li>					
				<button form="form_admin" type="submit" name="submitcontinuar" value="true" onclick="$('#'+this.getAttribute('form')).submit();">
					<span class="mdi mdi-content-save-move-outline"></span> Atualizar Pauta
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
					<li class="tab-title active"><a href="#form">Formulário de Pauta</a></li>
					<li class="tab-title"><a href="#text">Pauta Escrita</a></li>
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
							<li class="active"><a href="#form">Formulário de Pauta</a></li>
							<li><a href="#text">Pauta Escrita</a></li>
						</ul>
					</section>
				</nav>
			</div>
			<div class="tabs-content">
				<div class="content active" id="form">
					<input id="idconfiguracao" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['idconfiguracao']->value;?>
">
					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('data');?>

					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('periodo');?>

					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('locutor1');?>

					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('locutor2');?>

					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('locutor3');?>

					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('calendario_sazonal');?>

					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('musica1');?>

					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('comentario_musica1');?>

					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('noticia1');?>

					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('musica2');?>

					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('comentario_musica2');?>


					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('curiosidade_dia');?>

					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('musica3');?>

					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('comentario_musica3');?>

					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('noticia_urgente');?>

					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('encerramento');?>

					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('musica4');?>

					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('musica5');?>

					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('musica6');?>


				</div>

				<div class="content active" id="text">
					<input id="idconfiguracao" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['idconfiguracao']->value;?>
">
					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('pauta_escrita');?>

				</div>
			</div>
		</div>
	</form>
</div>
<?php }
}
