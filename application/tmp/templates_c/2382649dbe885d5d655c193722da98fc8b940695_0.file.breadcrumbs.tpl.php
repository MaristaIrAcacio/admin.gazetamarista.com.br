<?php
/* Smarty version 3.1.36, created on 2024-07-26 06:39:42
  from 'c:\xampp-7.4\htdocs\admin.gazetamarista.com.br\application\layouts\breadcrumbs.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_66a36ede05df77_51657500',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2382649dbe885d5d655c193722da98fc8b940695' => 
    array (
      0 => 'c:\\xampp-7.4\\htdocs\\admin.gazetamarista.com.br\\application\\layouts\\breadcrumbs.tpl',
      1 => 1721433141,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_66a36ede05df77_51657500 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\xampp-7.4\\htdocs\\admin.gazetamarista.com.br\\library\\gazetamarista\\Library\\Smarty\\plugins\\modifier.replace.php','function'=>'smarty_modifier_replace',),));
?>
<ul class="breadcrumbs">
    <li>
    	<a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url(array('module'=>'admin','controller'=>'index','action'=>'index'),'default',TRUE);?>
">Dashboard</a>
    </li>

	<?php if (count($_smarty_tpl->tpl_vars['this']->value->pages) > 0) {?>
		<?php $_smarty_tpl->_assignInScope('page_name', '');?>
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['this']->value->pages, 'page', false, 'key');
$_smarty_tpl->tpl_vars['page']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['page']->value) {
$_smarty_tpl->tpl_vars['page']->do_else = false;
?>
			<?php if ($_smarty_tpl->tpl_vars['key']->value < count($_smarty_tpl->tpl_vars['this']->value->pages)-1) {?>
				<li class="unavailable">
					<?php echo $_smarty_tpl->tpl_vars['page']->value->getLabel();?>

				</li>
			<?php } else { ?>
				<li>
					<a href="<?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['page']->value->getHref(),'/form','/list');?>
"><?php echo $_smarty_tpl->tpl_vars['page']->value->getLabel();?>
</a>
				</li>
			<?php }?>
			<?php $_smarty_tpl->_assignInScope('page_name', $_smarty_tpl->tpl_vars['page']->value->getLabel());?>
		<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
	<?php } else { ?>
		<li class="unavailable">
			<?php echo $_smarty_tpl->tpl_vars['this']->value->breadcrumb('menuitem-categoria');?>

		</li>

		<?php if (!empty($_smarty_tpl->tpl_vars['controller']->value)) {?>
			<li>
				<a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url(array('module'=>'admin','controller'=>$_smarty_tpl->tpl_vars['controller']->value,'action'=>'list'),'default',TRUE);?>
"><?php echo $_smarty_tpl->tpl_vars['this']->value->breadcrumb('menuitem-descricao');?>
</a>
			</li>
		<?php }?>
	<?php }?>
</ul>

<?php if (!empty($_smarty_tpl->tpl_vars['page_name']->value)) {?>
	<h2 style="text-transform: capitalize;">
		<?php echo $_smarty_tpl->tpl_vars['page_name']->value;?>
 <?php if ($_smarty_tpl->tpl_vars['paginator']->value) {?><span style="font-size:13px;">(Total itens: <?php echo $_smarty_tpl->tpl_vars['paginator']->value->getTotalItemCount();?>
)</span><?php }?> <?php if ($_smarty_tpl->tpl_vars['qtd_registros']->value) {?><span style="font-size:13px;">(Total itens: <?php echo $_smarty_tpl->tpl_vars['qtd_registros']->value;?>
)</span><?php }?>
	</h2>
<?php }
}
}
