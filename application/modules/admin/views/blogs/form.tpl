<div class="row">
	<div class="small-12 columns buttons-bar">
		<ul class="stack-for-small button-group">
			<li>
				<a href="{$this->url(['module'=>'admin', 'controller'=>$controller, 'action'=>'list'], 'default', TRUE)}{$filtrosParam}" class="button secondary normal" id="cancel">
					<span class="mdi mdi-sort-variant"></span> Voltar para listagem
				</a>
			</li>
			<li>
				<button form="form_admin" type="submit" name="submit" onclick="$('#'+this.getAttribute('form')).submit();">
					<span class="mdi mdi-content-save-move-outline"></span> {$form->getElement('submit')->getLabel()}
				</button>
			</li>
			{if $id > 0}
				<li class="btn_save-continue">
					<button form="form_admin" type="submit" name="submitcontinuar" value="true" onclick="$('#'+this.getAttribute('form')).submit();">
						<span class="mdi mdi-content-save-edit-outline"></span> {$form->getElement('submit')->getLabel()} e continuar editando
					</button>
				</li>
			{/if}
		</ul>
		<p class="cleafix show-for-small-only"></p>
	</div>
	
	<div class="small-12 columns">
		<div class="show-for-medium-up">
			<ul class="tabs" data-tab data-options="deep_linking:true">
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
				{$form}
			</div>
		</div>
	</div>
</div>