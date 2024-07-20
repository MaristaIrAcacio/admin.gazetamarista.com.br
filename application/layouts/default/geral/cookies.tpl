{if !aceitou_cookies()}
	<div id="cookies">
		<div>
			<p>Usamos Cookies para personalizar e melhorar a sua experiência em nosso site. Visite nossa
				<a class="uk-text-underline uk-text-bold modalPolitica" data-fancybox
						{literal}data-options='{"baseClass":"modal-cookies", "touch":false}' {/literal}
						data-src="#modal-politica-privacidade" href="javascript:void(0);">Política de Cookies</a> para saber mais.
			</p>
			<p>Ao clicar em "aceitar" você concorda com o uso que fazemos dos cookies.</p>
			<div class="uk-text-center uk-text-right@m">
				<a class="uk-button uk-button-primary uk-button-outline uk-border-rounded aceitar-cookies"
						data-href="{url('cookies-aceitar')}">Aceitar</a>
			</div>
		</div>
	</div>
{/if}
<div style="display:none;" id="modal-politica-privacidade">
	<div class="modal-header uk-flex uk-flex-center uk-flex-middle">
		<h1>Política de Cookies</h1>
	</div>
	<div class="modal-conteudo">
		{cookies_texto()}
	</div>
	<div class="modal-footer uk-flex uk-flex-center uk-flex-middle">
		{if !aceitou_cookies()}
			<div class="uk-button uk-button-primary aceitar-cookies" data-href="{url('cookies-aceitar')}">Aceitar</div>
		{/if}
	</div>
</div>
