<?php
/* Smarty version 3.1.36, created on 2024-07-21 20:21:35
  from 'c:\xampp-7.4\htdocs\admin.gazetamarista.com.br\application\modules\admin\views\materiaspendente\form.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_669d97ffd9a999_66197233',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '60c2dd9255718c54265806483be161691df5e2d8' => 
    array (
      0 => 'c:\\xampp-7.4\\htdocs\\admin.gazetamarista.com.br\\application\\modules\\admin\\views\\materiaspendente\\form.tpl',
      1 => 1721602283,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_669d97ffd9a999_66197233 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="row">
	<div class="small-12 columns buttons-bar">
		<ul class="stack-for-small button-group">
			<li>
				<a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url(array('module'=>'admin','controller'=>$_smarty_tpl->tpl_vars['controller']->value,'action'=>'list'),'default',TRUE);?>
" class="button alert btn-listagem" id="cancel">
					<span class="mdi mdi-backburger"></span> Voltar para listagem
				</a>
			</li>
			<li>
				<button class="btn-aprovar" style="display: flex;gap: 10px; align-items: center;" form="form_admin" type="submit" name="submit" onclick="$('#'+this.getAttribute('form')).submit();">
					<span class="mdi mdi-bookmark-check"></span>Aprovar
				</button>
			</li>
			<li>
				<button id="btn-reprovar" class="btn-reprovar" style="display: flex;gap: 10px; align-items: center;" form="form_admin" type="button" name="submit">
					<span class="mdi mdi-bookmark-remove"></span>Reprovar
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
