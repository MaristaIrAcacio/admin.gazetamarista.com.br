<?php
/* Smarty version 3.1.36, created on 2024-07-19 21:34:47
  from 'c:\xampp-7.4\htdocs\admin.gazetamarista.com.br\application\modules\admin\views\index\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_669b0627597310_28637124',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ff8221c0d924dba4a43cc1ea6452a8fbcbbda6fe' => 
    array (
      0 => 'c:\\xampp-7.4\\htdocs\\admin.gazetamarista.com.br\\application\\modules\\admin\\views\\index\\index.tpl',
      1 => 1721433141,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_669b0627597310_28637124 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['logged_usuario']->value['idperfil'] > 2) {?>
	<div class="row" id="container">
		<div class="columns dasboard-list" id="sortable">

			<div class="blocoNumeros ui-state-default">
				<h5><i class="mdi mdi-cursor-move"></i> Total Geral</h5>

				<div class="BlocoNumero BlocoLaranja">
					<i class="mdi mdi-cellphone-information"></i>
					<div class="Dados">
						<h4><?php echo $_smarty_tpl->tpl_vars['resumo']->value['qtd_contato'];?>
</h4>
						<span>Contato<?php if ($_smarty_tpl->tpl_vars['resumo']->value['qtd_contato'] > 1) {?>s<?php }?></span>
					</div>
				</div>
				<div class="BlocoNumero BlocoVerde">
					<i class="mdi mdi-email"></i>
					<div class="Dados">
						<h4><?php echo $_smarty_tpl->tpl_vars['resumo']->value['qtd_email'];?>
</h4>
						<span>E-mail<?php if ($_smarty_tpl->tpl_vars['resumo']->value['qtd_email'] > 1) {?>s<?php }?></span>
					</div>
				</div>
				<div class="BlocoNumero BlocoAmarelo">
					<i class="mdi mdi-toolbox-outline"></i>
					<div class="Dados">
						<h4><?php echo $_smarty_tpl->tpl_vars['resumo']->value['qtd_servicos'];?>
</h4>
						<span>Serviço<?php if ($_smarty_tpl->tpl_vars['resumo']->value['qtd_servicos'] > 1) {?>s<?php }?></span>
					</div>
				</div>
				<div class="BlocoNumero BlocoAzul">
					<i class="mdi mdi-newspaper-variant-outline"></i>
					<div class="Dados">
						<h4><?php echo $_smarty_tpl->tpl_vars['resumo']->value['qtd_noticias'];?>
</h4>
						<span>Notícia<?php if ($_smarty_tpl->tpl_vars['resumo']->value['qtd_noticias'] > 1) {?>s<?php }?></span>
					</div>
				</div>
			</div>

			<div class="bloco ui-state-default">
				<h5><i class="mdi mdi-cursor-move"></i> Últimos Contatos</h5>
				<table class="list">
					<tbody>
                    <?php if (count($_smarty_tpl->tpl_vars['contatos']->value) > 0) {?>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['contatos']->value, 'row');
$_smarty_tpl->tpl_vars['row']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->do_else = false;
?>
                            <tr data-link="<?php echo $_smarty_tpl->tpl_vars['basePath']->value;?>
/admin/contatos/view/idcontato/<?php echo $_smarty_tpl->tpl_vars['row']->value['idcontato'];?>
">
                                <td>#<?php echo $_smarty_tpl->tpl_vars['row']->value['idcontato'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['nome'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['email'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['this']->value->dateformat("%d/%m/%Y",$_smarty_tpl->tpl_vars['row']->value['data']);?>
</td>
                            </tr>
                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        <tr data-link="<?php echo $_smarty_tpl->tpl_vars['basePath']->value;?>
/admin/contatos/list"><td class="verlista" colspan="3"><i class="mdi mdi-format-list-bulleted"></i> Ver Listagem</td></tr>
                    <?php } else { ?>
                        <tr><td colspan="4" style="text-align: center; color: red;">Nenhum item encontrado.</td></tr>
                    <?php }?>
					</tbody>
				</table>
			</div>

			<div class="bloco ui-state-default">
				<h5><i class="mdi mdi-cursor-move"></i> Últimos E-mails</h5>
				<table class="list">
					<tbody>
                    <?php if (count($_smarty_tpl->tpl_vars['emails']->value) > 0) {?>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['emails']->value, 'row');
$_smarty_tpl->tpl_vars['row']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->do_else = false;
?>
                            <tr data-link="<?php echo $_smarty_tpl->tpl_vars['basePath']->value;?>
/admin/emails/view/idemail/<?php echo $_smarty_tpl->tpl_vars['row']->value['idemail'];?>
">
                                <td>#<?php echo $_smarty_tpl->tpl_vars['row']->value['idemail'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['email'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['this']->value->dateformat("%d/%m/%Y",$_smarty_tpl->tpl_vars['row']->value['data']);?>
</td>
                            </tr>
                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        <tr data-link="<?php echo $_smarty_tpl->tpl_vars['basePath']->value;?>
/admin/emails/list"><td class="verlista" colspan="4"><i class="mdi mdi-format-list-bulleted"></i> Ver Listagem</td></tr>
                    <?php } else { ?>
                        <tr><td colspan="3" style="text-align: center; color: red;">Nenhum item encontrado.</td></tr>
                    <?php }?>
					</tbody>
				</table>
			</div>

			<div class="bloco ui-state-default">
				<h5><i class="mdi mdi-cursor-move"></i> Últimas notícias</h5>
				<table class="list">
					<tbody>
                    <?php if (count($_smarty_tpl->tpl_vars['blogs']->value) > 0) {?>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['blogs']->value, 'row');
$_smarty_tpl->tpl_vars['row']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->do_else = false;
?>
                            <tr data-link="<?php echo $_smarty_tpl->tpl_vars['basePath']->value;?>
/admin/blogs/view/idblog/<?php echo $_smarty_tpl->tpl_vars['row']->value['idblog'];?>
">
                                <td>#<?php echo $_smarty_tpl->tpl_vars['row']->value['idblog'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['titulo'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['autor'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['this']->value->dateformat("%d/%m/%Y",$_smarty_tpl->tpl_vars['row']->value['data']);?>
</td>
                            </tr>
                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        <tr data-link="<?php echo $_smarty_tpl->tpl_vars['basePath']->value;?>
/admin/blogs/list"><td class="verlista" colspan="3"><i class="mdi mdi-format-list-bulleted"></i> Ver Listagem</td></tr>
                    <?php } else { ?>
                        <tr><td colspan="4" style="text-align: center; color: red;">Nenhum item encontrado.</td></tr>
                    <?php }?>
					</tbody>
				</table>
			</div>

			<div class="bloco ui-state-default">
				<h5><i class="mdi mdi-cursor-move"></i> Últimos Serviços</h5>
				<table class="list">
					<tbody>
                    <?php if (count($_smarty_tpl->tpl_vars['servicos']->value) > 0) {?>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['servicos']->value, 'row');
$_smarty_tpl->tpl_vars['row']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->do_else = false;
?>
                            <tr data-link="<?php echo $_smarty_tpl->tpl_vars['basePath']->value;?>
/admin/servicos/view/idemail/<?php echo $_smarty_tpl->tpl_vars['row']->value['idservico'];?>
">
                                <td>#<?php echo $_smarty_tpl->tpl_vars['row']->value['idservico'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['titulo'];?>
</td>
                            </tr>
                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        <tr data-link="<?php echo $_smarty_tpl->tpl_vars['basePath']->value;?>
/admin/servicos/list"><td class="verlista" colspan="4"><i class="mdi mdi-format-list-bulleted"></i> Ver Listagem</td></tr>
                    <?php } else { ?>
                        <tr><td colspan="3" style="text-align: center; color: red;">Nenhum item encontrado.</td></tr>
                    <?php }?>
					</tbody>
				</table>
			</div>

		</div>
	</div>
<?php }
}
}
