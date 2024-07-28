<?php
/* Smarty version 3.1.36, created on 2024-07-27 17:06:43
  from 'c:\xampp-7.4\htdocs\admin.gazetamarista.com.br\application\modules\admin\views\charges\list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_66a55353134c48_00306217',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c183392d535fa399a92ebd81c1fada87df250fb2' => 
    array (
      0 => 'c:\\xampp-7.4\\htdocs\\admin.gazetamarista.com.br\\application\\modules\\admin\\views\\charges\\list.tpl',
      1 => 1722087618,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_66a55353134c48_00306217 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="row">	
	<div class="small-12 columns buttons-bar">
		<ul class="stack-for-small button-group">
			<?php $_smarty_tpl->_assignInScope('url', $_smarty_tpl->tpl_vars['this']->value->CreateUrl("form",NULL,NULL,array()));?>
			<?php if ($_smarty_tpl->tpl_vars['somenteview']->value != true) {?>
				<?php if ($_smarty_tpl->tpl_vars['esconderBtnNovo']->value != true) {?>
					<li>
						<a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
" class="button btn-new">
							<i class="mdi mdi-plus-circle-outline"></i> Nova Charge
						</a>
					</li>
				<?php }?>
			<?php }?>

			<?php if (count($_smarty_tpl->tpl_vars['paginator']->value) > 0) {?>
				<?php if ($_smarty_tpl->tpl_vars['gerarxls']->value !== false) {?>
					<li class="exportxls">
						<a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url(array('module'=>'admin','controller'=>$_smarty_tpl->tpl_vars['controller']->value,'action'=>'exportarxls'),'default',TRUE);
echo $_smarty_tpl->tpl_vars['filtrosParam']->value;?>
" target="_blank" class="button">
							<i class="mdi mdi-file-excel"></i> Exportar lista (xls)
						</a>
					</li>
				<?php }?>
			<?php }?>
		</ul>
	</div>
	
	<?php if ($_smarty_tpl->tpl_vars['esconderBtnFiltrar']->value != true) {?>
		<div id="filtros" class="reveal-modal" data-reveal aria-labelledby="Filtros" aria-hidden="true" role="dialog">
			<h2>Filtrar </h2>
			<form action="<?php ob_start();
echo key($_smarty_tpl->tpl_vars['requireParam']->value);
$_prefixVariable1 = ob_get_clean();
ob_start();
echo current($_smarty_tpl->tpl_vars['requireParam']->value);
$_prefixVariable2 = ob_get_clean();
echo $_smarty_tpl->tpl_vars['this']->value->url(array('module'=>'admin','controller'=>$_smarty_tpl->tpl_vars['controller']->value,'action'=>'search',$_prefixVariable1,$_prefixVariable2),'default',TRUE);?>
" method="post">
				<div class="row">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_model']->value->getCampo(), 'value', false, 'column');
$_smarty_tpl->tpl_vars['value']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['column']->value => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->do_else = false;
?>
						<?php if ($_smarty_tpl->tpl_vars['_model']->value->getVisibility($_smarty_tpl->tpl_vars['column']->value,'list') || $_smarty_tpl->tpl_vars['_model']->value->getVisibility($_smarty_tpl->tpl_vars['column']->value,'search')) {?>
							<?php echo $_smarty_tpl->tpl_vars['form']->value->getElement($_smarty_tpl->tpl_vars['column']->value);?>

						<?php }?>
					<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
					<p class="clearfix"></p>
				</div>
				
				<div class="row">
					<div class="small-12 medium-2 columns">
						<button type="submit" class="expand">Buscar</button>
					</div>
					<div class="small-12 medium-2 end columns">
						<button type="reset" class="input-reset-search expand button secondary normal" data-url="<?php echo $_smarty_tpl->tpl_vars['basePath']->value;?>
/admin/<?php echo $_smarty_tpl->tpl_vars['currentController']->value;?>
/list" ><span class="mdi mdi-backburger"></span> Limpar</button>
					</div>
				</div>
			</form>
			<a class="close-reveal-modal" aria-label="Close">&#215;</a>
		</div>
	<?php }?>
</div>

<?php if (count($_smarty_tpl->tpl_vars['listExtraIcons']->value) > 0) {?>
	<div class="row">
		<div class="small-12 columns">
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['listExtraIcons']->value, 'icon');
$_smarty_tpl->tpl_vars['icon']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['icon']->value) {
$_smarty_tpl->tpl_vars['icon']->do_else = false;
?>
				<a class="<?php echo $_smarty_tpl->tpl_vars['icon']->value['class'];?>
" href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url($_smarty_tpl->tpl_vars['icon']->value['url'],'default',$_smarty_tpl->tpl_vars['icon']->value['clear']);?>
"><?php echo $_smarty_tpl->tpl_vars['icon']->value['value'];?>
</a>
			<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
		</div>
	</div>
<?php }
}
}
