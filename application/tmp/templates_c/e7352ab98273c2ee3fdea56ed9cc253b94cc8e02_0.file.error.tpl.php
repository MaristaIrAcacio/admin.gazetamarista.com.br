<?php
/* Smarty version 3.1.36, created on 2024-07-19 21:07:05
  from 'c:\xampp-7.4\htdocs\rkadvisors.com.br\application\modules\default\views\error\error.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_669affa9eec972_62922988',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e7352ab98273c2ee3fdea56ed9cc253b94cc8e02' => 
    array (
      0 => 'c:\\xampp-7.4\\htdocs\\rkadvisors.com.br\\application\\modules\\default\\views\\error\\error.tpl',
      1 => 1721433141,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_669affa9eec972_62922988 (Smarty_Internal_Template $_smarty_tpl) {
?><main id="site-corpo" class="main-error">
    <div class="uk-container">
        <?php if ($_smarty_tpl->tpl_vars['displayexceptions']->value) {?>
            <section>
                <h1>An error occurred</h1>
                <h2><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</h2>
                <h3>Exception information:</h3>
                <p><?php echo $_smarty_tpl->tpl_vars['exception_message']->value;?>
</p>
                <h3>Stack trace:</h3>
                <pre><?php echo $_smarty_tpl->tpl_vars['trace']->value;?>
</pre>
                <?php if ((isset($_smarty_tpl->tpl_vars['extras']->value))) {?>
                    <h3>Extras:</h3>
                    <pre><?php echo $_smarty_tpl->tpl_vars['extras']->value;?>
</pre>
                <?php }?>
                <h3>Request Parameters:</h3>
                <pre><?php echo $_smarty_tpl->tpl_vars['params']->value;?>
</pre>
            </section>
        <?php }?>
        <div class="uk-text-center uk-padding">
            <a href="<?php echo url('home');?>
">
                <img src="common/default/images/404.png" alt="404 Página não encontrada! Não encontramos essa página em nosso sevidor.">
            </a>
        </div>
    </div>
</main><?php }
}
