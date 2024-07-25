<?php
/* Smarty version 3.1.36, created on 2024-07-24 21:03:10
  from 'c:\xampp-7.4\htdocs\admin.gazetamarista.com.br\application\layouts\print.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_66a1963ebddf75_27544064',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1de25a2fbbb07f042ce49c3dfd05cb7a8d67daa8' => 
    array (
      0 => 'c:\\xampp-7.4\\htdocs\\admin.gazetamarista.com.br\\application\\layouts\\print.tpl',
      1 => 1721433141,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_66a1963ebddf75_27544064 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div style="width: 730px; margin: auto;">
	<div>
        <div style="clear: both; float: left; width: 220px; padding: 5px;"><b>ID:</b></div>
        <div style="float: left; width: 480px; padding: 5px;">#<?php echo $_smarty_tpl->tpl_vars['idregistro']->value;?>
</div>
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_model']->value->getCampo(), 'value', false, 'column');
$_smarty_tpl->tpl_vars['value']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['column']->value => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->do_else = false;
?>
			<div style="clear: both; float: left; width: 220px; padding: 5px;"><b><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
:</b></div>
            <div style="float: left; width: 480px; padding: 5px;"><?php echo $_smarty_tpl->tpl_vars['dados']->value[$_smarty_tpl->tpl_vars['column']->value];?>
</div>
		<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
	</div>
</div>
<?php }
}
