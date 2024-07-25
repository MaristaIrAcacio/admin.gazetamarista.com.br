<?php
/* Smarty version 3.1.36, created on 2024-07-24 22:03:26
  from 'c:\xampp-7.4\htdocs\admin.gazetamarista.com.br\application\layouts\paginator.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_66a1a45ea9ba90_26021732',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2af13e3c1aa633008beceafd9ee794c1efc51826' => 
    array (
      0 => 'c:\\xampp-7.4\\htdocs\\admin.gazetamarista.com.br\\application\\layouts\\paginator.tpl',
      1 => 1721697083,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_66a1a45ea9ba90_26021732 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="pagination-centered">
	<ul class="pagination">
		
		<li><a <?php if ((isset($_smarty_tpl->tpl_vars['previous']->value))) {?>href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url(array('page'=>$_smarty_tpl->tpl_vars['this']->value->first));?>
"<?php }?> class="border-left">«</a></li>
		<li><a <?php if ((isset($_smarty_tpl->tpl_vars['previous']->value))) {?>href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url(array('page'=>$_smarty_tpl->tpl_vars['previous']->value));?>
"<?php }?> class="no-border">&lsaquo;</a></li>
		
		
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pagesInRange']->value, 'page');
$_smarty_tpl->tpl_vars['page']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['page']->value) {
$_smarty_tpl->tpl_vars['page']->do_else = false;
?>
			<?php if ($_smarty_tpl->tpl_vars['page']->value != $_smarty_tpl->tpl_vars['this']->value->current) {?>
				<li><a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url(array('page'=>$_smarty_tpl->tpl_vars['page']->value));?>
"><?php echo $_smarty_tpl->tpl_vars['page']->value;?>
</a></li>
			<?php } else { ?>
				<li class="current"><a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url(array('page'=>$_smarty_tpl->tpl_vars['page']->value));?>
"><?php echo $_smarty_tpl->tpl_vars['page']->value;?>
</a></li>
			<?php }?>
		<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
		
		
		<li><a <?php if ((isset($_smarty_tpl->tpl_vars['next']->value))) {?>href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url(array('page'=>$_smarty_tpl->tpl_vars['next']->value));?>
"<?php }?> class="no-border">&rsaquo;</a></li>
		<li><a <?php if ((isset($_smarty_tpl->tpl_vars['next']->value))) {?>href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url(array('page'=>$_smarty_tpl->tpl_vars['last']->value));?>
"<?php }?> class="border-right">»</a></li>
		
	</ul>
</div><?php }
}
