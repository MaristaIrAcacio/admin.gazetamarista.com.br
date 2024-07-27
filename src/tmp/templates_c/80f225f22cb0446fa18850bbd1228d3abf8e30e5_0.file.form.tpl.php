<?php
/* Smarty version 3.1.36, created on 2024-07-27 17:06:07
  from 'c:\xampp-7.4\htdocs\admin.gazetamarista.com.br\application\modules\admin\views\charges\form.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_66a5532fdd32b4_86060201',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '80f225f22cb0446fa18850bbd1228d3abf8e30e5' => 
    array (
      0 => 'c:\\xampp-7.4\\htdocs\\admin.gazetamarista.com.br\\application\\modules\\admin\\views\\charges\\form.tpl',
      1 => 1721868137,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_66a5532fdd32b4_86060201 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\xampp-7.4\\htdocs\\admin.gazetamarista.com.br\\library\\gazetamarista\\Library\\Smarty\\plugins\\modifier.capitalize.php','function'=>'smarty_modifier_capitalize',),));
?>
<div class="row">
	<div class="small-12 columns buttons-bar">
		<ul class="stack-for-small button-group">
			<li>
				<a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url(array('module'=>'admin','controller'=>$_smarty_tpl->tpl_vars['controller']->value,'action'=>'list'),'default',TRUE);
echo $_smarty_tpl->tpl_vars['filtrosParam']->value;?>
" class="button secondary normal">
					<span class="mdi mdi-backburger"></span> Voltar para listagem
				</a>
			</li>

			<li>
				<button id="enviarParaAprovacao" style="display: flex;gap: 10px; align-items: center;" form="form_admin" type="submit" name="submit" onclick="$('#'+this.getAttribute('form')).submit();">
					<span class="mdi mdi-content-save"></span>Enviar Para Aprovação
				</button>
			</li>
		</ul>
		<p class="cleafix show-for-small-only"></p>
	</div>

	<form enctype="multipart/form-data" id="form_admin" action="<?php echo $_smarty_tpl->tpl_vars['form']->value->getAction();?>
" method="post" data-idprimary="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" data-abide>	
		<div class="small-12 columns">
			<div class="show-for-medium-up">
				<ul class="tabs" data-tab data-options="deep_linking:true">
					<?php if (!empty($_smarty_tpl->tpl_vars['_tabs']->value)) {?>
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_tabs']->value, '_tab', false, 'key');
$_smarty_tpl->tpl_vars['_tab']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['_tab']->value) {
$_smarty_tpl->tpl_vars['_tab']->do_else = false;
?>
							<li class="tab-title <?php if ($_smarty_tpl->tpl_vars['key']->value == 0) {?>active<?php }?>"><a href="#<?php echo mb_strtolower($_smarty_tpl->tpl_vars['_tab']->value['url'], 'UTF-8');?>
"><?php echo smarty_modifier_capitalize($_smarty_tpl->tpl_vars['_tab']->value['name']);?>
</a></li>
						<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
					<?php }?>
					<?php if (!empty($_smarty_tpl->tpl_vars['_tabscompletas']->value)) {?>
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_tabscompletas']->value, '_tabcompleta', false, 'key');
$_smarty_tpl->tpl_vars['_tabcompleta']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['_tabcompleta']->value) {
$_smarty_tpl->tpl_vars['_tabcompleta']->do_else = false;
?>
							<li class="tab-title <?php if ($_smarty_tpl->tpl_vars['key']->value == 0 && empty($_smarty_tpl->tpl_vars['_tabs']->value)) {?>active<?php }?>"><a href="#<?php echo mb_strtolower($_smarty_tpl->tpl_vars['_tabcompleta']->value['url'], 'UTF-8');?>
"><?php echo smarty_modifier_capitalize($_smarty_tpl->tpl_vars['_tabcompleta']->value['name']);?>
</a></li>
						<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
					<?php }?>
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
							<?php if (!empty($_smarty_tpl->tpl_vars['_tabs']->value)) {?>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_tabs']->value, '_tab', false, 'key');
$_smarty_tpl->tpl_vars['_tab']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['_tab']->value) {
$_smarty_tpl->tpl_vars['_tab']->do_else = false;
?>
									<li class="<?php if ($_smarty_tpl->tpl_vars['key']->value == 0) {?>active<?php }?>"><a href="#<?php echo mb_strtolower($_smarty_tpl->tpl_vars['_tab']->value['url'], 'UTF-8');?>
"><?php echo smarty_modifier_capitalize($_smarty_tpl->tpl_vars['_tab']->value['name']);?>
</a></li>
								<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
							<?php }?>
							<?php if (!empty($_smarty_tpl->tpl_vars['_tabscompletas']->value)) {?>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_tabscompletas']->value, '_tabcompleta', false, 'key');
$_smarty_tpl->tpl_vars['_tabcompleta']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['_tabcompleta']->value) {
$_smarty_tpl->tpl_vars['_tabcompleta']->do_else = false;
?>
									<li class="<?php if ($_smarty_tpl->tpl_vars['key']->value == 0 && empty($_smarty_tpl->tpl_vars['_tabs']->value)) {?>active<?php }?>"><a href="#<?php echo mb_strtolower($_smarty_tpl->tpl_vars['_tabcompleta']->value['url'], 'UTF-8');?>
"><?php echo smarty_modifier_capitalize($_smarty_tpl->tpl_vars['_tabcompleta']->value['name']);?>
</a></li>
								<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
							<?php }?>
						</ul>
					</section>
				</nav>
			</div>
			<div class="tabs-content">
				<?php if (!empty($_smarty_tpl->tpl_vars['_tabs']->value)) {?>
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_tabs']->value, '_tab', false, 'key');
$_smarty_tpl->tpl_vars['_tab']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['_tab']->value) {
$_smarty_tpl->tpl_vars['_tab']->do_else = false;
?>
						<div class="content <?php if ($_smarty_tpl->tpl_vars['key']->value == 0) {?>active<?php }?>" id="<?php echo mb_strtolower($_smarty_tpl->tpl_vars['_tab']->value['url'], 'UTF-8');?>
">
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['form']->value->getElements(), 'element');
$_smarty_tpl->tpl_vars['element']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['element']->value) {
$_smarty_tpl->tpl_vars['element']->do_else = false;
?>
								<?php if ($_smarty_tpl->tpl_vars['element']->value->getName() != "submit" && $_smarty_tpl->tpl_vars['element']->value->getName() != "cancel") {?>
									<?php if (mb_strtolower($_smarty_tpl->tpl_vars['_tab']->value['url'], 'UTF-8') == mb_strtolower($_smarty_tpl->tpl_vars['element']->value->tab, 'UTF-8')) {?>
										<?php echo $_smarty_tpl->tpl_vars['element']->value;?>

									<?php } else { ?>
										<?php if (mb_strtolower($_smarty_tpl->tpl_vars['element']->value->tab, 'UTF-8') == null && $_smarty_tpl->tpl_vars['key']->value == 0) {?>
											<?php echo $_smarty_tpl->tpl_vars['element']->value;?>

										<?php }?>
									<?php }?>
								<?php }?>
							<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
						</div>
					<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
				<?php } else { ?>
					<div class="content active">
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['form']->value->getElements(), 'element');
$_smarty_tpl->tpl_vars['element']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['element']->value) {
$_smarty_tpl->tpl_vars['element']->do_else = false;
?>
							<?php if ($_smarty_tpl->tpl_vars['element']->value->getName() != "submit" && $_smarty_tpl->tpl_vars['element']->value->getName() != "cancel") {?>
								<?php echo $_smarty_tpl->tpl_vars['element']->value;?>

							<?php }?>
						<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
					</div>
				<?php }?>
				
								
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_tabscompletas']->value, '_tabcompleta');
$_smarty_tpl->tpl_vars['_tabcompleta']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_tabcompleta']->value) {
$_smarty_tpl->tpl_vars['_tabcompleta']->do_else = false;
?>
					<div class="content" id="<?php echo mb_strtolower($_smarty_tpl->tpl_vars['_tabcompleta']->value['url'], 'UTF-8');?>
">
						<?php $_smarty_tpl->_assignInScope('Condicao', ((string)$_smarty_tpl->tpl_vars['TableName']->value).".".((string)$_smarty_tpl->tpl_vars['primary']->value));?>
						<?php $_smarty_tpl->_assignInScope('_tab_list', $_smarty_tpl->tpl_vars['_tabcompleta']->value['model']->fetchAll($_smarty_tpl->tpl_vars['_tabcompleta']->value['select']->where(($_smarty_tpl->tpl_vars['Condicao']->value).(' = ?'),$_smarty_tpl->tpl_vars['id']->value)));?>
						<?php $_smarty_tpl->_assignInScope('_tab_primary', current($_smarty_tpl->tpl_vars['_tabcompleta']->value['model']->getPrimaryField()));?>
						<?php $_smarty_tpl->_assignInScope('_tab_infos', $_smarty_tpl->tpl_vars['_tabcompleta']->value['model']->info());?>
						<?php $_smarty_tpl->_assignInScope('_tab_columns', $_smarty_tpl->tpl_vars['_tabcompleta']->value['model']->getCampo());?>

						<table width="100%" cellpadding="0" cellspacing="0" class="list">
							<thead>
								<tr>
									<th>#</th>
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_tab_list']->value->current(), 'value', false, 'column');
$_smarty_tpl->tpl_vars['value']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['column']->value => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->do_else = false;
?>
										<?php if ($_smarty_tpl->tpl_vars['_tabcompleta']->value['model']->getVisibility($_smarty_tpl->tpl_vars['column']->value,'list')) {?>
											<th>
												<?php echo $_smarty_tpl->tpl_vars['_tab_columns']->value[$_smarty_tpl->tpl_vars['column']->value];?>

											</th>
										<?php }?>
									<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
								</tr>
							</thead>
							<tbody>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_tab_list']->value, '_tab_row');
$_smarty_tpl->tpl_vars['_tab_row']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_tab_row']->value) {
$_smarty_tpl->tpl_vars['_tab_row']->do_else = false;
?>
									<tr>
										<td>
											<?php echo $_smarty_tpl->tpl_vars['_tab_row']->value[$_smarty_tpl->tpl_vars['_tab_primary']->value];?>

										</td>
									</tr>
								<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
							</tbody>
						</table>
					</div>
				<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
			</div>
		</div>
		
		<?php if ((($tmp = @$_smarty_tpl->tpl_vars['id']->value)===null||$tmp==='' ? 0 : $tmp) > 0) {?>
			<input type=hidden name="referer_url" value="<?php echo $_smarty_tpl->tpl_vars['this']->value->url(array('module'=>'admin','controller'=>$_smarty_tpl->tpl_vars['controller']->value,'action'=>'list'),'default',FALSE);?>
">
		<?php }?>
	</form>
</div>
<?php }
}
