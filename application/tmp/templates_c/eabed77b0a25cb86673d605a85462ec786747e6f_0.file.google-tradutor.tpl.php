<?php
/* Smarty version 3.1.36, created on 2024-07-19 21:12:22
  from 'C:\xampp-7.4\htdocs\admin.gazetamarista.com.br\application\layouts\default\geral\google-tradutor.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_669b00e60ce979_93540842',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'eabed77b0a25cb86673d605a85462ec786747e6f' => 
    array (
      0 => 'C:\\xampp-7.4\\htdocs\\admin.gazetamarista.com.br\\application\\layouts\\default\\geral\\google-tradutor.tpl',
      1 => 1721433141,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_669b00e60ce979_93540842 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 type="text/javascript">
	var gt_screen_width =
		window.innerWidth ||
		document.documentElement.clientWidth ||
		document.body.clientWidth;

	function googleTranslateElementInit() {
		new google.translate.TranslateElement(
			{
				pageLanguage: "pt",
				includedLanguages: "pt,en,es",
				layout: google.translate.TranslateElement.InlineLayout.VERTICAL,
				autoDisplay: false,
			},
			"google_translate_element"
		);
	}
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript">
	var srciptNode = document.createElement("script");
	srciptNode.setAttribute("type", "text/javascript");
	srciptNode.setAttribute(
		"src",
		"https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"
	);
	document.body.appendChild(srciptNode);
<?php echo '</script'; ?>
>
<?php }
}
