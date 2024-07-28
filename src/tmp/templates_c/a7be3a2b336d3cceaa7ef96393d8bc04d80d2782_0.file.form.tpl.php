<?php
/* Smarty version 3.1.36, created on 2024-07-27 16:58:49
  from 'c:\xampp-7.4\htdocs\admin.gazetamarista.com.br\application\modules\admin\views\materiasrascunhos\form.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_66a551798e85c0_20773492',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a7be3a2b336d3cceaa7ef96393d8bc04d80d2782' => 
    array (
      0 => 'c:\\xampp-7.4\\htdocs\\admin.gazetamarista.com.br\\application\\modules\\admin\\views\\materiasrascunhos\\form.tpl',
      1 => 1721577643,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_66a551798e85c0_20773492 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="row">
	<div class="small-12 columns buttons-bar">
		<ul class="stack-for-small button-group">
			<li>
				<a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url(array('module'=>'admin','controller'=>$_smarty_tpl->tpl_vars['controller']->value,'action'=>'list'),'default',TRUE);?>
" class="button alert" id="cancel">
					<span class="mdi mdi-backburger"></span> Voltar para listagem
				</a>
			</li>
			<li>
				<button id="salvarComoRascunho" class="hidden" style="display: flex;gap: 10px; align-items: center;" form="form_admin" type="submit" name="submit" onclick="$('#'+this.getAttribute('form')).submit();">
					<span class="mdi mdi-content-save"></span>Salvar como rascunho
				</button>
				<button id="enviarParaAprovacao" style="display: flex;gap: 10px; align-items: center;" form="form_admin" type="submit" name="submit" onclick="$('#'+this.getAttribute('form')).submit();">
					<span class="mdi mdi-content-save"></span>Enviar Para Aprovação
				</button>
			</li>
		</ul>
		<p class="cleafix show-for-small-only"></p>
	</div>
	<form enctype="multipart/form-data" id="form_admin" action="<?php echo $_smarty_tpl->tpl_vars['form']->value->getAction();?>
" method="post" data-abide>
		<div class="small-12 columns">
			<div class="show-for-medium-up">
				<ul class="tabs" data-tab>
					<li class="tab-title active"><a href="#geral">Rascunho</a></li>
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
						<ul class="left" data-tab>
							<li class="active"><a href="#geral">Rascunho</a></li>
						</ul>
					</section>
				</nav>
			</div>
			<div class="tabs-content">
				<div class="content active" id="geral">
					<?php echo $_smarty_tpl->tpl_vars['form']->value;?>

				</div>
			</div>
		</div>
	</form>
</div>
<?php }
}
