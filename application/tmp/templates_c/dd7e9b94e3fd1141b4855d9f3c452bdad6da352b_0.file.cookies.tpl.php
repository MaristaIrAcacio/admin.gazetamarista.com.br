<?php
/* Smarty version 3.1.36, created on 2024-07-19 21:10:01
  from 'C:\xampp-7.4\htdocs\rkadvisors.com.br\application\layouts\default\geral\cookies.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_669b005964bd64_69531709',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'dd7e9b94e3fd1141b4855d9f3c452bdad6da352b' => 
    array (
      0 => 'C:\\xampp-7.4\\htdocs\\rkadvisors.com.br\\application\\layouts\\default\\geral\\cookies.tpl',
      1 => 1721433141,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_669b005964bd64_69531709 (Smarty_Internal_Template $_smarty_tpl) {
if (!aceitou_cookies()) {?>
	<div id="cookies">
		<div>
			<p>Usamos Cookies para personalizar e melhorar a sua experiência em nosso site. Visite nossa
				<a class="uk-text-underline uk-text-bold modalPolitica" data-fancybox
						data-options='{"baseClass":"modal-cookies", "touch":false}' 
						data-src="#modal-politica-privacidade" href="javascript:void(0);">Política de Cookies</a> para saber mais.
			</p>
			<p>Ao clicar em "aceitar" você concorda com o uso que fazemos dos cookies.</p>
			<div class="uk-text-center uk-text-right@m">
				<a class="uk-button uk-button-primary uk-button-outline uk-border-rounded aceitar-cookies"
						data-href="<?php echo url('cookies-aceitar');?>
">Aceitar</a>
			</div>
		</div>
	</div>
<?php }?>
<div style="display:none;" id="modal-politica-privacidade">
	<div class="modal-header uk-flex uk-flex-center uk-flex-middle">
		<h1>Política de Cookies</h1>
	</div>
	<div class="modal-conteudo">
		<?php echo cookies_texto();?>

	</div>
	<div class="modal-footer uk-flex uk-flex-center uk-flex-middle">
		<?php if (!aceitou_cookies()) {?>
			<div class="uk-button uk-button-primary aceitar-cookies" data-href="<?php echo url('cookies-aceitar');?>
">Aceitar</div>
		<?php }?>
	</div>
</div>
<?php }
}
