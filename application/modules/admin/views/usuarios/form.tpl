<div class="row">
	<div class="small-12 columns buttons-bar">
		<ul class="stack-for-small button-group">
			<li>
				<a href="{$this->url(['module'=>'admin', 'controller'=>$controller, 'action'=>'list'], 'default', TRUE)}" class="button alert" id="cancel">
					<span class="mdi mdi-backburger"></span> Voltar para listagem
				</a>
			</li>
			<li>
				<button form="form_admin" type="submit" name="submit" onclick="$('#'+this.getAttribute('form')).submit();">
					<span class="mdi mdi-content-save-move-outline"></span> {$form->getElement('submit')->getLabel()}
				</button>
			</li>
			{if $id > 0}
				<li>					
					<button form="form_admin" type="submit" name="submitcontinuar" value="true" onclick="$('#'+this.getAttribute('form')).submit();">
						<span class="mdi mdi-content-save-edit-outline"></span> {$form->getElement('submit')->getLabel()} e continuar editando
					</button>
				</li>
			{/if}
		</ul>
		<p class="cleafix show-for-small-only"></p>
	</div>
	<form enctype="multipart/form-data" id="form_admin" action="{$form->getAction()}" method="post" data-abide>
		<div class="small-12 columns">
			<div class="show-for-medium-up">
				<ul class="tabs" data-tab>
					<li class="tab-title active"><a href="#geral">Geral</a></li>
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
						<ul class="left" data-tab>
							<li class="active"><a href="#geral">Geral</a></li>
						</ul>
					</section>
				</nav>
			</div>
			<div class="tabs-content">
				<div class="content active" id="geral">
					{$form->getElement('idperfil')}
					{$form->getElement('nome')}
					{$form->getElement('email')}
					{$form->getElement('login')}
					{$form->getElement('senha')}
					<div class="element-form" id="element-senha_confirmar">
						<div class="row">
							<div class="small-12 medium-12 large-12 columns labeldiv" id="label-senha_confirmar">
								<label for="senha_confirmar">Confirme Senha
									<div class="clearfix"></div>
									<small class="error">Senhas não conferem</small>
								</label>
							</div>
							<div class="input-form small-12 medium-2 large-2 columns end">
								<input name="senha_confirmar" id="senha_confirmar" value="" field-type="text" class="varchar string radius" type="password" pattern="[a-zA-Z]+" data-equalto="senha">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
