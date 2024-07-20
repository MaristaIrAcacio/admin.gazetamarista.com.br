<div class="uk-hidden@m">
	{* TODO: Deixar escrito na div abaixo o nome da página atual *}
	<div class="links-painel-mobile-container">Meus dados<i class="icon-arrow-c-down"></i></div>
	<div uk-dropdown="mode: click; offset: 0">
		<ul>
			{if $currentAction !== 'meus-dados'}<li><a href="{url('meus-dados')}">Meus dados</a></li>{/if}
			{if $currentAction !== 'minhas-compras'}<li><a href="{url('minhas-compras')}">Minhas compras</a></li>{/if}
			{if $currentAction !== 'meus-cartoes'}<li><a href="{url('meus-cartoes')}">Meus cartões</a></li>{/if}
			{if $currentAction !== 'meus-enderecos'}<li><a href="{url('meus-enderecos')}">Meus endereços</a></li>{/if}
		</ul>
	</div>
</div>
<div class="links-painel-container uk-visible@m">
	<ul>
		<li><a {if $currentAction === 'meus-dados'}class="active"{/if} href="{url('meus-dados')}">Meus dados</a></li>
		<li><a {if $currentAction === 'minhas-compras'}class="active"{/if} href="{url('minhas-compras')}">Minhas compras</a></li>
		<li><a {if $currentAction === 'meus-cartoes'}class="active"{/if} href="{url('meus-cartoes')}">Meus cartões</a></li>
		<li><a {if $currentAction === 'meus-enderecos'}class="active"{/if} href="{url('meus-enderecos')}">Meus endereços</a></li>
		<li><a href="#modal-sair" uk-toggle>Sair</a></li>
	</ul>
</div>