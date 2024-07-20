<?php
/* Smarty version 3.1.36, created on 2024-07-19 21:12:21
  from 'C:\xampp-7.4\htdocs\admin.gazetamarista.com.br\application\layouts\default\geral\rodape.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_669b00e5c420c0_74970019',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd38734c2515d51bd9c6739d1dd82607da3339894' => 
    array (
      0 => 'C:\\xampp-7.4\\htdocs\\admin.gazetamarista.com.br\\application\\layouts\\default\\geral\\rodape.tpl',
      1 => 1721433700,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:default/geral/google-tradutor.tpl' => 1,
  ),
),false)) {
function content_669b00e5c420c0_74970019 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\xampp-7.4\\htdocs\\admin.gazetamarista.com.br\\library\\gazetamarista\\Library\\Smarty\\plugins\\modifier.replace.php','function'=>'smarty_modifier_replace',),));
?>
<footer id="site-rodape">
	<div class="footer-container">
		<div class="navigation-container">
			<ul class="filiais">
				<?php
$_smarty_tpl->tpl_vars['numFilial'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['numFilial']->step = 1;$_smarty_tpl->tpl_vars['numFilial']->total = (int) ceil(($_smarty_tpl->tpl_vars['numFilial']->step > 0 ? 4+1 - (1) : 1-(4)+1)/abs($_smarty_tpl->tpl_vars['numFilial']->step));
if ($_smarty_tpl->tpl_vars['numFilial']->total > 0) {
for ($_smarty_tpl->tpl_vars['numFilial']->value = 1, $_smarty_tpl->tpl_vars['numFilial']->iteration = 1;$_smarty_tpl->tpl_vars['numFilial']->iteration <= $_smarty_tpl->tpl_vars['numFilial']->total;$_smarty_tpl->tpl_vars['numFilial']->value += $_smarty_tpl->tpl_vars['numFilial']->step, $_smarty_tpl->tpl_vars['numFilial']->iteration++) {
$_smarty_tpl->tpl_vars['numFilial']->first = $_smarty_tpl->tpl_vars['numFilial']->iteration === 1;$_smarty_tpl->tpl_vars['numFilial']->last = $_smarty_tpl->tpl_vars['numFilial']->iteration === $_smarty_tpl->tpl_vars['numFilial']->total;?>

					<?php $_smarty_tpl->_assignInScope('cidadeFilial', $_smarty_tpl->tpl_vars['_configuracao']->value->{"filial_".((string)$_smarty_tpl->tpl_vars['numFilial']->value)."_cidade"});?>
					<?php $_smarty_tpl->_assignInScope('enderecoFilial', $_smarty_tpl->tpl_vars['_configuracao']->value->{"filial_".((string)$_smarty_tpl->tpl_vars['numFilial']->value)."_endereco"});?>
					<?php $_smarty_tpl->_assignInScope('complementoFilial', $_smarty_tpl->tpl_vars['_configuracao']->value->{"filial_".((string)$_smarty_tpl->tpl_vars['numFilial']->value)."_complemento"});?>
					<?php $_smarty_tpl->_assignInScope('telefoneFilial', $_smarty_tpl->tpl_vars['_configuracao']->value->{"filial_".((string)$_smarty_tpl->tpl_vars['numFilial']->value)."_telefone"});?>
					<?php $_smarty_tpl->_assignInScope('telefoneLimpo', smarty_modifier_replace(smarty_modifier_replace(smarty_modifier_replace(smarty_modifier_replace(smarty_modifier_replace($_smarty_tpl->tpl_vars['telefoneFilial']->value,'+',''),'(',''),')',''),'-',''),' ',''));?>

					<?php if ($_smarty_tpl->tpl_vars['cidadeFilial']->value && $_smarty_tpl->tpl_vars['enderecoFilial']->value) {?>

						<li>
							<h3><?php echo $_smarty_tpl->tpl_vars['cidadeFilial']->value;?>
</h3>
							<p><?php echo $_smarty_tpl->tpl_vars['enderecoFilial']->value;?>
<br />
								<?php echo $_smarty_tpl->tpl_vars['complementoFilial']->value;?>
</p>
							<a href="<?php if ($_smarty_tpl->tpl_vars['telefoneLimpo']->value) {?>tel:<?php echo $_smarty_tpl->tpl_vars['telefoneLimpo']->value;
} else {
echo url('contato');
}?>">
								<?php if ($_smarty_tpl->tpl_vars['telefoneFilial']->value) {
echo $_smarty_tpl->tpl_vars['telefoneFilial']->value;
} else { ?>Enviar Mensagem<?php }?>
							</a>
						</li>
					<?php }?>
				<?php }
}
?>
			</ul>

		</div>

		<div class="social-container">
			<ul>
				<?php if (!empty($_smarty_tpl->tpl_vars['_configuracao']->value->facebook)) {?>
					<li>
						<a href="<?php echo tratar_link_externo($_smarty_tpl->tpl_vars['_configuracao']->value->facebook);?>
" target="_blank" rel="noopener noreferrer">
							<img class="icon-facebook" width="24px" height="24px"
								src="common/default/images/icons/Icon-facebook.svg" alt="" srcset="">
						</a>
					</li>
				<?php }?>
				<?php if (!empty($_smarty_tpl->tpl_vars['_configuracao']->value->instagram)) {?>
					<li>
						<a href="<?php echo tratar_link_externo($_smarty_tpl->tpl_vars['_configuracao']->value->instagram);?>
" target="_blank"
							rel="noopener noreferrer">
							<img class="icon-instagram" width="23.99px" height="24px"
								src="common/default/images/icons/Icon-instagram.svg" alt="" srcset="">
						</a>
					</li>
				<?php }?>
				<?php if (!empty($_smarty_tpl->tpl_vars['_configuracao']->value->youtube)) {?>
					<li>
						<a href="<?php echo tratar_link_externo($_smarty_tpl->tpl_vars['_configuracao']->value->youtube);?>
" target="_blank" rel="noopener noreferrer">
							<img class="icon-youtube" width="24px" height="16.91px"
								src="common/default/images/icons/Icon-youtube.svg" alt="" srcset="">
						</a>
					</li>
				<?php }?>
				<?php if (!empty($_smarty_tpl->tpl_vars['_configuracao']->value->linkedin)) {?>
					<li>
						<a href="<?php echo tratar_link_externo($_smarty_tpl->tpl_vars['_configuracao']->value->linkedin);?>
" target="_blank" rel="noopener noreferrer">
							<img class="icon-linkedin" width="24px" height="24px"
								src="common/default/images/icons/linkedin.svg" alt="" srcset="">
						</a>
					</li>
				<?php }?>
			</ul>
		</div>
		<div class="cidades-rodape">
			<p><?php echo $_smarty_tpl->tpl_vars['_configuracao']->value->cidade_rodape;?>
</p>
		</div>
		<div class="uk-text-right gazetamarista">
			<a href="https://www.gazetamarista.com.br/?utm_source=site_nahrung&utm_medium=link+copyright&utm_content=link+copyright&utm_campaign=link+copyright"
				target="_blank" class="icon-gazetamarista"></a>
		</div>
	</div>
</footer>

<!-- Menu offcanvas -->
<div style="display:none;">
	<nav class="offcanvas-menu">
		<ul>
			<div class="header">
				<a href="<?php echo url('home');?>
">
					<figure>
						<img src="common/default/images/logos/Logo.svg" alt="<?php echo $_smarty_tpl->tpl_vars['_configuracao']->value->nome_site;?>
" uk-img />
					</figure>
				</a>
				<button class="uk-button btn-menu btn-menu-offcanvas-fechar">
					<svg width="50" height="50" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect x="0.5" y="0.5" width="39" height="39" rx="4.5" stroke="#525254" />
						<path
							d="M13.2827 26.7177L20.0002 20.0002M20.0002 20.0002L26.7177 13.2827M20.0002 20.0002L26.7177 26.7177M20.0002 20.0002L13.2827 13.2827"
							stroke="#525254" />
					</svg>
				</button>
			</div>
			<div class="botoes">
				<li class="">
					<a href="<?php echo url('sobre-nos');?>
" class="nav-item">Sobre nós</a>
				</li>
				<li>
					<a href="<?php echo url('servicos');?>
" class="nav-item">Serviços</a>

				</li>
				<li>
					<a href="<?php echo url('noticias');?>
" class="nav-item">BLOG</a>

				</li>
				<li>
					<a href="<?php echo url('contato');?>
" class="nav-item">Contato</a>
				</li>
				<li>
					<img src="common/default/images/logos/Logo-cmm.svg" alt="" />
				</li>
			</div>
			<div class="footer">
				<div class="translate-mobile-container" translate="no">
					<button class="uk-button" data-idioma="pt">
						<span>PT</span>
						<img src="common/default/images/countries/br.svg" alt="BR Flag" class="flag br">
					</button>

					<button class="uk-button" data-idioma="en">
						<span>EN</span>
						<img src="common/default/images/countries/us.svg" alt="US Flag" class="flag us">
					</button>

					<button class="uk-button" data-idioma="es">
						<span>ES</span>
						<img src="common/default/images/countries/es.svg" alt="ES Flag" class="flag es">
					</button>
				</div>
			</div>
		</ul>
	</nav>
</div>

<div id="google_translate_element"></div>

<!-- Google Tradutor -->
<?php $_smarty_tpl->_subTemplateRender("file:default/geral/google-tradutor.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
