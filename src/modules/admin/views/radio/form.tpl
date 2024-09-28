<div class="row">
	<div class="small-12 columns buttons-bar">
		<ul class="stack-for-small button-group">
			<li>
				<a href="{$this->url(['module'=>'admin', 'controller'=>$controller, 'action'=>'list'], 'default', TRUE)}" class="button alert" id="cancel">
					<span class="mdi mdi-backburger"></span> Visualizar pautas
				</a>
			</li>
			<li>					
				<button form="form_admin" type="submit" name="submitcontinuar" value="true" onclick="$('#'+this.getAttribute('form')).submit();">
					<span class="mdi mdi-content-save-move-outline"></span> Atualizar Pauta
				</button>
			</li>
		</ul>
		<p class="cleafix show-for-small-only"></p>
	</div>
	<form enctype="multipart/form-data" id="form_admin" action="{$form->getAction()}" method="post" data-abide>
		<div class="small-12 columns">
			<div class="show-for-medium-up">
				<ul class="tabs" data-tab data-options="deep_linking:true">
					<li class="tab-title active"><a href="#form">Formulário de Pauta</a></li>
					<li class="tab-title"><a href="#text">Pauta Escrita</a></li>
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
							<li class="active"><a href="#form">Formulário de Pauta</a></li>
							<li><a href="#text">Pauta Escrita</a></li>
						</ul>
					</section>
				</nav>
			</div>
			<div class="tabs-content">
				<div class="content active" id="form">
					<input id="idconfiguracao" type="hidden" value="{$idconfiguracao}">
					{$form->getElement('data')}
					{$form->getElement('periodo')}
					{$form->getElement('locutor1')}
					{$form->getElement('locutor2')}
					{$form->getElement('locutor3')}
					{$form->getElement('calendario_sazonal')}
					{$form->getElement('musica1')}
					{$form->getElement('comentario_musica1')}
					{$form->getElement('noticia1')}
					{$form->getElement('musica2')}
					{$form->getElement('comentario_musica2')}

					{$form->getElement('curiosidade_dia')}
					{$form->getElement('musica3')}
					{$form->getElement('comentario_musica3')}
					{$form->getElement('noticia_urgente')}
					{$form->getElement('encerramento')}
					{$form->getElement('musica4')}
					{$form->getElement('musica5')}
					{$form->getElement('musica6')}

				</div>

				<div class="content active" id="text">
					<input id="idconfiguracao" type="hidden" value="{$idconfiguracao}">
					{$form->getElement('pauta_escrita')}
				</div>
			</div>
		</div>
	</form>
</div>
