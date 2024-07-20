<?php
/* Smarty version 3.1.36, created on 2024-07-19 21:10:01
  from 'C:\xampp-7.4\htdocs\rkadvisors.com.br\application\layouts\default\geral\topo.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_669b0059138559_69648962',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0cefc4e0a3eb109bbe710fdacf05e6c1f829109d' => 
    array (
      0 => 'C:\\xampp-7.4\\htdocs\\rkadvisors.com.br\\application\\layouts\\default\\geral\\topo.tpl',
      1 => 1721433221,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_669b0059138559_69648962 (Smarty_Internal_Template $_smarty_tpl) {
?><header id="site-topo">
	<div class="header-container">
		<div class="logo">
			<a href="<?php echo url('home');?>
">
				<figure>
					<img src="common/default/images/logos/Logo.svg" alt="<?php echo $_smarty_tpl->tpl_vars['_configuracao']->value->nome_site;?>
" uk-img />
				</figure>
			</a>
		</div>
		<nav class="uk-visible@m">
			<a href="<?php echo url('sobre-nos');?>
" class="nav-item">Sobre nós</a>
			<a href="<?php echo url('servicos');?>
" class="nav-item">Serviços</a>
			<a href="<?php echo url('noticias');?>
" class="nav-item">BLOG</a>
			<a href="<?php echo url('contato');?>
" class="nav-item">Contato</a>
			<img src="common/default/images/logos/Logo-cmm.svg" alt="" />
			<div class="translate-container uk-visible@s">
				<button class="uk-button coluna-idioma" uk-toggle="target: #modal-traducao">
					<img src="common/default/images/countries/br.svg" alt="Flag" class="flag">
					<svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M4 6L0 0H8L4 6Z" fill="#98989A" />
					</svg>
				</button>
			</div>
		</nav>
		<div class="menu-container uk-hidden@m">
			<button class="uk-button btn-menu btn-menu-offcanvas-abrir">
				<svg width="50" height="50" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect x="0.5" y="0.5" width="39" height="39" rx="4.5" stroke="#525254" />
					<path d="M10 15H30M10 20H30M10 25H30" stroke="#525254" />
				</svg>
			</button>
		</div>
	</div>
</header>

<div id="modal-traducao" class="uk-flex-top" uk-modal>
	<div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical" translate="no">
		<div class="header uk-hidden@s">
			<figure uk-toggle="#modal-traducao">
				<img src="common/default/images/logos/logo.svg" alt="<?php echo $_smarty_tpl->tpl_vars['_configuracao']->value->nome_site;?>
" uk-img />
			</figure>
		</div>

		<h2 class="titulo-language">Selecione seu idioma</h2>
		<p class="titulo-language-2">Select your language</p>
		<p class="titulo-language-3">Elige tu idioma</p>

		<div class="buttons-container">
			<button class="uk-button uk-button-fourth" data-idioma="pt">
				<img src="common/default/images/countries/br.svg" alt="BR Flag" class="flag br">
				<span>Português</span>
			</button>

			<button class="uk-button uk-button-fourth" data-idioma="en">
				<img src="common/default/images/countries/us.svg" alt="US Flag" class="flag us">
				<span>English</span>
			</button>

			<button class="uk-button uk-button-fourth" data-idioma="es">
				<img src="common/default/images/countries/es.svg" alt="ES Flag" class="flag es">
				<span>Español</span>
			</button>
		</div>
	</div>
</div>
<?php }
}
