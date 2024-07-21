<?php
/* Smarty version 3.1.36, created on 2024-07-21 11:00:39
  from 'c:\xampp-7.4\htdocs\admin.gazetamarista.com.br\application\modules\admin\views\usuarios\trocarsenha.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_669d148793d9f3_80192591',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4526f599f6c8577682586f60dbe4b8c9b6bfd99c' => 
    array (
      0 => 'c:\\xampp-7.4\\htdocs\\admin.gazetamarista.com.br\\application\\modules\\admin\\views\\usuarios\\trocarsenha.tpl',
      1 => 1721433141,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_669d148793d9f3_80192591 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="row">
	<div class="small-12 columns buttons-bar">
		<ul class="stack-for-small button-group">
			<li>
				<a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url(array('module'=>'admin'),'default',TRUE);?>
" class="button secondary normal">
					<span class="mdi mdi-backburger"></span> Voltar
				</a>
			</li>

			<li>
				<button form="form_trocarsenha" type="submit" name="submit" >
					<span class="mdi mdi-content-save-move-outline"></span> Trocar Senha
				</button>
			</li>

		</ul>
		<p class="cleafix show-for-small-only"></p>
	</div>


	<form enctype="multipart/form-data" id="form_trocarsenha" action="<?php echo $_smarty_tpl->tpl_vars['this']->value->url(array('module'=>'admin','controller'=>'usuarios','action'=>'trocarsenha'),'default',TRUE);?>
" method="post" data-abide>
		<div class="small-12 columns">
			<div class="show-for-medium-up">
				<ul class="tabs" data-tab>
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
					<div class="element-form" id="element-senha_atual">
						<div class="row">
							<div class="small-12 medium-12 large-12 columns labeldiv" id="label-senha_atual">
								<label for="senha_atual" class="required">Senha Atual*
									<div class="clearfix"></div>
									<small></small>
								</label>
							</div>
							<div class="input-form small-12 medium-6 large-4 columns end">
								<input name="senha_atual" id="senha_atual" value="" field-type="text" class="varchar string radius" required type="password">
							</div>
						</div>
					</div>

					<div class="element-form" id="element-senha_nova">
						<div class="row">
							<div class="small-12 medium-12 large-12 columns labeldiv" id="label-senha_nova">
								<label for="senha_nova" class="required">Nova Senha*
									<div class="clearfix"></div>
									<small></small>
								</label>
							</div>
							<div class="input-form small-12 medium-6 large-4 columns end">
								<input name="senha_nova" id="senha_nova" value="" field-type="text" class="varchar string radius" required type="password">
							</div>
						</div>
					</div>

					<div class="element-form" id="element-senha_confirmar">
						<div class="row">
							<div class="small-12 medium-12 large-12 columns labeldiv" id="label-senha_confirmar">
								<label for="senha_confirmar" class="required">Confirme Senha*
									<div class="clearfix"></div>
									<small class="error">Senhas não conferem</small>
								</label>
							</div>
							<div class="input-form small-12 medium-6 large-4 columns end">
								<input name="senha_confirmar" id="senha_confirmar" value="" field-type="text" class="varchar string radius" required type="password" data-equalto="senha_nova">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>		
	</form>
</div>
<?php }
}
