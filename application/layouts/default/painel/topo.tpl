<header id="site-topo-painel">
	<div class="header-container">
		<div class="logo">
			<a href="{url('home')}">
				<figure>
					<img src="common/default/images/logos/logo.svg" alt="{$_configuracao->nome_site}" uk-img />
				</figure>
			</a>
		</div>
		<div class="user-container">
			<h2>Olá, {$_cliente->first_name}</h2>
			<i class="icon-arrow-c-down"></i>
		</div>
		<div uk-dropdown="mode: click; pos: bottom-right; offset: -10" style="display: none;">
			<ul class="uk-nav uk-dropdown-nav">
				<li><a href="#modal-sair" uk-toggle>Sair</a></li>
				<li><a href="#modal-excluir-conta" uk-toggle>Excluir conta</a></li>
			</ul>
		</div>
	</div>
</header>

{* Confirmar sair *}
<div id="modal-sair" class="uk-flex-top modal-padrao" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
        <h3 class="titulo-padrao">SAIR</h3>
		<p class="subtitle">Deseja mesmo sair da sua conta?</p> 
		<input type="text" name="idendereco" hidden value="0">
		<div class="buttons-container">
			<button type="button" class="uk-button uk-button-secondary uk-modal-close">Voltar</button>
			<a href="{url('logout')}">
				<button type="submit" class="uk-button uk-button-black btn-enviar">Sair</button>
			</a>
		</div>
    </div>
</div>

{* Confirmar excluir conta *}
<div id="modal-excluir-conta" class="uk-flex-top modal-padrao" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
        <h3 class="titulo-padrao">EXCLUIR CONTA</h3>
		<p class="subtitle">Ao concluir todos os dados relacionados a sua conta serão perdidos.</p> 
		<div class="buttons-container">
			<button type="button" class="uk-button uk-button-secondary uk-modal-close">Cancelar</button>
			<a href="{url('excluir-conta')}">
				<button type="submit" class="uk-button uk-button-black btn-enviar">Excluir</button>
			</a>
		</div>
    </div>
</div>
