<?php
/* Smarty version 3.1.36, created on 2024-07-27 17:06:55
  from 'c:\xampp-7.4\htdocs\admin.gazetamarista.com.br\application\modules\admin\views\chargespendente\list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_66a5535f2017a7_64613251',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '06a4f611a1a4e1f05375cca314192c0cfd2695f5' => 
    array (
      0 => 'c:\\xampp-7.4\\htdocs\\admin.gazetamarista.com.br\\application\\modules\\admin\\views\\chargespendente\\list.tpl',
      1 => 1722087545,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_66a5535f2017a7_64613251 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\xampp-7.4\\htdocs\\admin.gazetamarista.com.br\\library\\gazetamarista\\Library\\Smarty\\plugins\\modifier.truncate.php','function'=>'smarty_modifier_truncate',),));
if (count($_smarty_tpl->tpl_vars['listExtraIcons']->value) > 0) {?>
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
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['somenteview']->value) {?>
	<?php $_smarty_tpl->_assignInScope('urldata', ((($_smarty_tpl->tpl_vars['this']->value->CreateUrl("view",NULL,NULL,array())).('/')).($_smarty_tpl->tpl_vars['primary']->value)).('/'));
} else { ?>
	<?php $_smarty_tpl->_assignInScope('urldata', ((($_smarty_tpl->tpl_vars['this']->value->CreateUrl("form",NULL,NULL,array())).('/')).($_smarty_tpl->tpl_vars['primary']->value)).('/'));
}?>

<?php $_smarty_tpl->_assignInScope('urldatavisualizar', ((($_smarty_tpl->tpl_vars['this']->value->CreateUrl("view",NULL,NULL,array())).('/')).($_smarty_tpl->tpl_vars['primary']->value)).('/'));?>

<?php $_smarty_tpl->_assignInScope('urldataimprimir', ($_smarty_tpl->tpl_vars['this']->value->CreateUrl("print",NULL,NULL,array())).('/id/'));?>

<div class="row">
	<div class="small-12 columns">
		<div class="table-list">
			<table class="responsive list">
				<thead>
					<tr>
						<th width="100">
							<div class="listcheckbox">
								<input type="checkbox" value="" id="selecionatodoslist" class="selecionatodoslist">
								<label for="selecionatodoslist"></label>
							</div>
							#
						</th>
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_model']->value->getCampo(), 'value', false, 'column');
$_smarty_tpl->tpl_vars['value']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['column']->value => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->do_else = false;
?>
							<?php if ($_smarty_tpl->tpl_vars['_model']->value->getVisibility($_smarty_tpl->tpl_vars['column']->value,'list')) {?>
								<th>
									<?php echo $_smarty_tpl->tpl_vars['value']->value;?>

								</th>
							<?php }?>
						<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
						<th width="50"></th>
					</tr>
				</thead>
				
				<tbody>
					<?php if (count($_smarty_tpl->tpl_vars['paginator']->value) > 0) {?>
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['paginator']->value, 'row');
$_smarty_tpl->tpl_vars['row']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->do_else = false;
?>
							<?php $_smarty_tpl->_assignInScope('urleditar', utf8_encode(($_smarty_tpl->tpl_vars['urldata']->value).($_smarty_tpl->tpl_vars['row']->value[$_smarty_tpl->tpl_vars['primary']->value])));?>
							<?php $_smarty_tpl->_assignInScope('urlvisualizar', utf8_encode(($_smarty_tpl->tpl_vars['urldatavisualizar']->value).($_smarty_tpl->tpl_vars['row']->value[$_smarty_tpl->tpl_vars['primary']->value])));?>
							<?php $_smarty_tpl->_assignInScope('urlimprimir', utf8_encode(($_smarty_tpl->tpl_vars['urldataimprimir']->value).($_smarty_tpl->tpl_vars['row']->value[$_smarty_tpl->tpl_vars['primary']->value])));?>

							<tr data-editar="<?php echo $_smarty_tpl->tpl_vars['urleditar']->value;?>
" data-visualizar="<?php echo $_smarty_tpl->tpl_vars['urlvisualizar']->value;?>
" class="<?php if ((isset($_smarty_tpl->tpl_vars['row']->value->ativo))) {
if ($_smarty_tpl->tpl_vars['row']->value->ativo == 0) {?>tr_inativa<?php }
}?>">
								<td width="100">
									<div class="listcheckbox">
										<input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['row']->value[$_smarty_tpl->tpl_vars['primary']->value];?>
" id="<?php echo $_smarty_tpl->tpl_vars['primary']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['row']->value[$_smarty_tpl->tpl_vars['primary']->value];?>
" name="<?php echo $_smarty_tpl->tpl_vars['primary']->value;?>
"/>
										<label for="<?php echo $_smarty_tpl->tpl_vars['primary']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['row']->value[$_smarty_tpl->tpl_vars['primary']->value];?>
"></label>
									</div>
									<span class="showId"><?php echo $_smarty_tpl->tpl_vars['row']->value[$_smarty_tpl->tpl_vars['primary']->value];?>
</span>
								</td>

								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_model']->value->getCampo(), 'value', false, 'column');
$_smarty_tpl->tpl_vars['value']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['column']->value => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->do_else = false;
?>
									<?php $_smarty_tpl->_assignInScope('conteudo_campo', $_smarty_tpl->tpl_vars['this']->value->GetColumnValue($_smarty_tpl->tpl_vars['row']->value,$_smarty_tpl->tpl_vars['column']->value));?>
									<?php if ($_smarty_tpl->tpl_vars['_model']->value->getVisibility($_smarty_tpl->tpl_vars['column']->value,'list')) {?>
										<td>
											<?php echo smarty_modifier_truncate(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['conteudo_campo']->value),200,"...");?>

										</td>
									<?php }?>
								<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

								<td class="coluna-acoes" >
									<?php $_smarty_tpl->_assignInScope('urlexcluirindividual', ((($_smarty_tpl->tpl_vars['this']->value->CreateUrl("delete",NULL,NULL,array())).('/')).($_smarty_tpl->tpl_vars['primary']->value)).('/'));?>
									<?php if ($_smarty_tpl->tpl_vars['_permitidoExcluir']->value) {?>
										<?php if ($_smarty_tpl->tpl_vars['esconderBtnRemover']->value != true) {?>
											<a href="<?php echo utf8_encode($_smarty_tpl->tpl_vars['urlexcluirindividual']->value);?>
" class="btn-remove-invidual" title="Excluir" data-id="<?php echo $_smarty_tpl->tpl_vars['row']->value[$_smarty_tpl->tpl_vars['primary']->value];?>
"><i class="mdi mdi-trash-can-outline btn-deletar-individual"></i></a>
										<?php }?>
									<?php }?>
								</td>
							</tr>
						<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
					<?php } else { ?>
						<tr><td colspan="10" style="text-align:center; color:#FF0000;"><b>Nenhum registro encontrado</b></td></tr>
					<?php }?>
				</tbody>
			</table>
		</div>
	</div>

	<div class="small-12 columns">
		<div class="footer-bar">
			<?php echo $_smarty_tpl->tpl_vars['this']->value->paginationControl($_smarty_tpl->tpl_vars['paginator']->value,NULL,'paginator.tpl');?>

		</div>
	</div>

</div>
<?php }
}
