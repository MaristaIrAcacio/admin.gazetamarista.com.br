<div class="row">
	<div class="small-12 columns buttons-bar">
		<ul class="stack-for-small button-group">
			<li>					
				<button form="form_admin" type="submit" name="submitcontinuar" value="true" onclick="$('#'+this.getAttribute('form')).submit();">
					<span class="mdi mdi-content-save-move-outline"></span> Atualizar informações
				</button>
			</li>
		</ul>
		<p class="cleafix show-for-small-only"></p>
	</div>
	<form enctype="multipart/form-data" id="form_admin" action="{$form->getAction()}" method="post" data-abide>
		<div class="small-12 columns">
			<div class="show-for-medium-up">
				<ul class="tabs" data-tab data-options="deep_linking:true">
					<li class="tab-title active"><a href="#geral">Geral</a></li>
					{if $idperfil === '99'}<li class="tab-title"><a href="#codigos">Códigos/Share</a></li>{/if}
					<li class="tab-title"><a href="#cookies">Política Cookies</a></li>
				</ul>
			</div>
			<div class="show-for-small-only">
				<nav class="top-bar" data-topbar role="navigation">
					<ul class="title-area">
						<li class="name">
						</li>
						<li class="toggle-topbar menu-icon">
							<a href="#"><span></span></a>
						</li>
					</ul>
					<section class="top-bar-section">
						<ul class="left" data-tab data-options="deep_linking:true">
							<li class="active"><a href="#geral">Geral</a></li>
							{if $idperfil === '99'}<li><a href="#codigos">Códigos/Share</a></li>{/if}
							<li><a href="#cookies">Política Cookies</a></li>
						</ul>
					</section>
				</nav>
			</div>
			<div class="tabs-content">
				<div class="content active" id="geral">
					<input id="idconfiguracao" type="hidden" value="{$idconfiguracao}">
					{$form->getElement('nome_site')}
					{$form->getElement('email_rodape')}
					{$form->getElement('email_contato')}
					{$form->getElement('facebook')}
					{$form->getElement('instagram')}
					{$form->getElement('linkedin')}
					{$form->getElement('whatsapp')}
					{$form->getElement('twitter')}
					{$form->getElement('cidade_rodape')}
				</div>

				<div class="content" id="codigos">
					{$form->getElement('recaptcha_key')}
					<br>
					{$form->getElement('recaptcha_secret')}
					<br>
					{$form->getElement('share_tag')}
					<br>
					{$form->getElement('codigo_final_head')}
					<br>
					{$form->getElement('codigo_inicio_body')}
					<br>
					{$form->getElement('codigo_final_body')}
				</div>

				<div class="content" id="cookies">
					{$form->getElement('politica_cookie_texto')}
				</div>
			</div>
		</div>
	</form>
</div>
