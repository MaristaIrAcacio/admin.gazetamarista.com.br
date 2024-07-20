<footer id="site-rodape">
	<div class="footer-container">
		<div class="navigation-container">
			<ul class="filiais">
				{for $numFilial=1 to 4}

					{assign var="cidadeFilial" value=$_configuracao->{"filial_{$numFilial}_cidade"}}
					{assign var="enderecoFilial" value=$_configuracao->{"filial_{$numFilial}_endereco"}}
					{assign var="complementoFilial" value=$_configuracao->{"filial_{$numFilial}_complemento"}}
					{assign var="telefoneFilial" value=$_configuracao->{"filial_{$numFilial}_telefone"}}
					{assign var="telefoneLimpo" value=$telefoneFilial|replace:'+':''|replace:'(':''|replace:')':''|replace:'-':''|replace:' ':''}

					{if $cidadeFilial && $enderecoFilial}

						<li>
							<h3>{$cidadeFilial}</h3>
							<p>{$enderecoFilial}<br />
								{$complementoFilial}</p>
							<a href="{if $telefoneLimpo}tel:{$telefoneLimpo}{else}{url('contato')}{/if}">
								{if $telefoneFilial}{$telefoneFilial}{else}Enviar Mensagem{/if}
							</a>
						</li>
					{/if}
				{/for}
			</ul>

		</div>

		<div class="social-container">
			<ul>
				{if !empty($_configuracao->facebook)}
					<li>
						<a href="{tratar_link_externo($_configuracao->facebook)}" target="_blank" rel="noopener noreferrer">
							<img class="icon-facebook" width="24px" height="24px"
								src="common/default/images/icons/Icon-facebook.svg" alt="" srcset="">
						</a>
					</li>
				{/if}
				{if !empty($_configuracao->instagram)}
					<li>
						<a href="{tratar_link_externo($_configuracao->instagram)}" target="_blank"
							rel="noopener noreferrer">
							<img class="icon-instagram" width="23.99px" height="24px"
								src="common/default/images/icons/Icon-instagram.svg" alt="" srcset="">
						</a>
					</li>
				{/if}
				{if !empty($_configuracao->youtube)}
					<li>
						<a href="{tratar_link_externo($_configuracao->youtube)}" target="_blank" rel="noopener noreferrer">
							<img class="icon-youtube" width="24px" height="16.91px"
								src="common/default/images/icons/Icon-youtube.svg" alt="" srcset="">
						</a>
					</li>
				{/if}
				{if !empty($_configuracao->linkedin)}
					<li>
						<a href="{tratar_link_externo($_configuracao->linkedin)}" target="_blank" rel="noopener noreferrer">
							<img class="icon-linkedin" width="24px" height="24px"
								src="common/default/images/icons/linkedin.svg" alt="" srcset="">
						</a>
					</li>
				{/if}
			</ul>
		</div>
		<div class="cidades-rodape">
			<p>{$_configuracao->cidade_rodape}</p>
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
				<a href="{url('home')}">
					<figure>
						<img src="common/default/images/logos/Logo.svg" alt="{$_configuracao->nome_site}" uk-img />
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
					<a href="{url('sobre-nos')}" class="nav-item">Sobre nós</a>
				</li>
				<li>
					<a href="{url('servicos')}" class="nav-item">Serviços</a>

				</li>
				<li>
					<a href="{url('noticias')}" class="nav-item">BLOG</a>

				</li>
				<li>
					<a href="{url('contato')}" class="nav-item">Contato</a>
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
{include file="default/geral/google-tradutor.tpl"}
