<?php
/* Smarty version 3.1.36, created on 2024-07-20 08:44:29
  from 'c:\xampp-7.4\htdocs\admin.gazetamarista.com.br\application\modules\admin\views\usuarios\form.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_669ba31d7b4237_00208669',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '61c3a6ca22bbaa74ec5306427e8538c335198ec6' => 
    array (
      0 => 'c:\\xampp-7.4\\htdocs\\admin.gazetamarista.com.br\\application\\modules\\admin\\views\\usuarios\\form.tpl',
      1 => 1721475123,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_669ba31d7b4237_00208669 (Smarty_Internal_Template $_smarty_tpl) {
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
				<button form="form_admin" type="submit" name="submit" onclick="$('#'+this.getAttribute('form')).submit();">
					<span class="mdi mdi-content-save-move-outline"></span> <?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('submit')->getLabel();?>

				</button>
			</li>
			<?php if ($_smarty_tpl->tpl_vars['id']->value > 0) {?>
				<li>					
					<button form="form_admin" type="submit" name="submitcontinuar" value="true" onclick="$('#'+this.getAttribute('form')).submit();">
						<span class="mdi mdi-content-save-edit-outline"></span> <?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('submit')->getLabel();?>
 e continuar editando
					</button>
				</li>
			<?php }?>
		</ul>
		<p class="cleafix show-for-small-only"></p>
	</div>
	<form enctype="multipart/form-data" id="form_admin" action="<?php echo $_smarty_tpl->tpl_vars['form']->value->getAction();?>
" method="post" data-abide>
		<div class="small-12 columns">
			<div class="show-for-medium-up">
				<ul class="tabs" data-tab>
					<li class="tab-title active"><a href="#geral">Geral</a></li>
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
							<li class="active"><a href="#geral">Geral</a></li>
						</ul>
					</section>
				</nav>
			</div>
			<div class="tabs-content">
				<div class="content active" id="geral">
					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('idperfil');?>

					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('avatar');?>

					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('nome');?>

					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('email');?>


					<hr>
					<h5 class="title-model">Escola</h5>
					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('serie');?>

					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('turma');?>


					<hr>
					<h5 class="title-model">Redes Sociais</h5>
					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('instagram');?>

					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('likedin');?>


					<hr>
					<h5 class="title-model">Autenticação</h5>
					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('login');?>

					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('senha');?>

					<div class="element-form" id="element-senha_confirmar">
						<div class="row">
							<div class="small-12 medium-12 large-12 columns labeldiv" id="label-senha_confirmar">
								<label for="senha_confirmar">Confirme Senha
									<div class="clearfix"></div>
									<small class="error">Senhas não conferem</small>
								</label>
							</div>
							<div class="input-form small-12 medium-2 large-2 columns end">
								<input name="senha_confirmar" id="senha_confirmar" value="" field-type="text" class="varchar string radius" type="password" pattern="[a-zA-Z]+" data-equalto="senha">
							</div>
						</div>
					</div>
					<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement('ativo');?>

				</div>
			</div>
		</div>
	</form>
</div>
<?php }
}
