<?php
/* Smarty version 3.1.36, created on 2024-07-24 22:03:30
  from 'c:\xampp-7.4\htdocs\admin.gazetamarista.com.br\application\layouts\view.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_66a1a4628fa4d3_25651307',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '76eb66d0d6c947562c7bbb365af941fa609ac84f' => 
    array (
      0 => 'c:\\xampp-7.4\\htdocs\\admin.gazetamarista.com.br\\application\\layouts\\view.tpl',
      1 => 1721433141,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_66a1a4628fa4d3_25651307 (Smarty_Internal_Template $_smarty_tpl) {
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
			<?php if ($_smarty_tpl->tpl_vars['id']->value > 0) {?>
				<?php if ($_smarty_tpl->tpl_vars['gerarpdf']->value !== false) {?>
					<?php $_smarty_tpl->_assignInScope('nome_pdf', (($_smarty_tpl->tpl_vars['controller']->value).('_cod')).($_smarty_tpl->tpl_vars['id']->value));?>
					<li>
						<a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url(array('module'=>'admin','controller'=>$_smarty_tpl->tpl_vars['controller']->value,'action'=>'exportpdf','id'=>$_smarty_tpl->tpl_vars['id']->value,'name'=>$_smarty_tpl->tpl_vars['nome_pdf']->value),'default',TRUE);?>
" target="_blank" class="button">
							<span class="mdi mdi-printer"></span> Imprimir
						</a>
					</li>
				<?php }?>
			<?php }?>
		</ul>
		<p class="cleafix show-for-small-only"></p>
	</div>
	
	<div id="div_all_view" class="small-12 columns">
		<div class="show-for-medium-up">
			<ul class="tabs" data-tab>
				<li class="tab-title active"></li>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_tabs']->value, '_tab');
$_smarty_tpl->tpl_vars['_tab']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_tab']->value) {
$_smarty_tpl->tpl_vars['_tab']->do_else = false;
?>
					<li class="tab-title"><a href="#<?php echo mb_strtolower($_smarty_tpl->tpl_vars['_tab']->value['name'], 'UTF-8');?>
"><?php echo smarty_modifier_capitalize($_smarty_tpl->tpl_vars['_tab']->value['name']);?>
</a></li>
				<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
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
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_tabs']->value, '_tab');
$_smarty_tpl->tpl_vars['_tab']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_tab']->value) {
$_smarty_tpl->tpl_vars['_tab']->do_else = false;
?>
							<li><a href="#<?php echo mb_strtolower($_smarty_tpl->tpl_vars['_tab']->value['name'], 'UTF-8');?>
"><?php echo smarty_modifier_capitalize($_smarty_tpl->tpl_vars['_tab']->value['name']);?>
</a></li>
						<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
					</ul>
				</section>
			</nav>
		</div>
		<div class="tabs-content">
			<div class="content active" id="geral">
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
			
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_tabs']->value, '_tab');
$_smarty_tpl->tpl_vars['_tab']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_tab']->value) {
$_smarty_tpl->tpl_vars['_tab']->do_else = false;
?>
				<div class="content" id="<?php echo mb_strtolower($_smarty_tpl->tpl_vars['_tab']->value['name'], 'UTF-8');?>
">
					<?php $_smarty_tpl->_assignInScope('_tab_list', $_smarty_tpl->tpl_vars['_tab']->value['model']->fetchAll($_smarty_tpl->tpl_vars['_tab']->value['select']->where(($_smarty_tpl->tpl_vars['primary']->value).(' = ?'),$_smarty_tpl->tpl_vars['id']->value)));?>
					<?php $_smarty_tpl->_assignInScope('_tab_primary', current($_smarty_tpl->tpl_vars['_tab']->value['model']->getPrimaryField()));?>
					<?php $_smarty_tpl->_assignInScope('_tab_infos', $_smarty_tpl->tpl_vars['_tab']->value['model']->info());?>
					<?php $_smarty_tpl->_assignInScope('_tab_columns', $_smarty_tpl->tpl_vars['_tab']->value['model']->getCampo());?>
					
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
									<?php if ($_smarty_tpl->tpl_vars['_tab']->value['model']->getVisibility($_smarty_tpl->tpl_vars['column']->value,'list')) {?>
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
							<tr data-url="<?php if (count($_smarty_tpl->tpl_vars['_tab']->value['url']) > 0) {
echo $_smarty_tpl->tpl_vars['this']->value->url($_smarty_tpl->tpl_vars['_tab']->value['url'],'default',TRUE);?>
/<?php echo $_smarty_tpl->tpl_vars['_tab_primary']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['_tab_row']->value[$_smarty_tpl->tpl_vars['_tab_primary']->value];
}?>">
								<td>
									<?php echo $_smarty_tpl->tpl_vars['_tab_row']->value[$_smarty_tpl->tpl_vars['_tab_primary']->value];?>

								</td>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_tab_row']->value, 'value', false, 'column');
$_smarty_tpl->tpl_vars['value']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['column']->value => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->do_else = false;
?>
									<?php if ($_smarty_tpl->tpl_vars['_tab']->value['model']->getVisibility($_smarty_tpl->tpl_vars['column']->value,'list')) {?>
										<td>
											<?php echo $_smarty_tpl->tpl_vars['this']->value->GetColumnValue($_smarty_tpl->tpl_vars['_tab_row']->value,$_smarty_tpl->tpl_vars['column']->value);?>

										</td>
									<?php }?>
								<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
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
		<input type="hidden" name="referer_url" value="<?php echo $_smarty_tpl->tpl_vars['this']->value->url(array('module'=>'admin','controller'=>$_smarty_tpl->tpl_vars['controller']->value,'action'=>'list'),'default',FALSE);?>
">
	<?php }?>
</div>
<?php }
}
