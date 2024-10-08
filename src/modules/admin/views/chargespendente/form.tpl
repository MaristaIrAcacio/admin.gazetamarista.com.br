<div class="row">
	<div class="small-12 columns buttons-bar">
		<ul class="stack-for-small button-group">
			<li>
				<a href="{$this->url(['module'=>'admin', 'controller'=>$controller, 'action'=>'list'], 'default', TRUE)}" class="button alert btn-listagem" id="cancel">
					<span class="mdi mdi-backburger"></span> Voltar para listagem
				</a>
			</li>
			<li>
				<button class="btn-aprovar" style="display: flex;gap: 10px; align-items: center;" form="form_admin" type="submit" name="submit" onclick="$('#'+this.getAttribute('form')).submit();">
					<span class="mdi mdi-bookmark-check"></span>Aprovar
				</button>
			</li>
			<li>
				<button id="btn-reprovar" class="btn-reprovar" style="display: flex;gap: 10px; align-items: center;" form="form_admin" type="button" name="submit">
					<span class="mdi mdi-bookmark-remove"></span>Reprovar
				</button>
			</li>
		</ul>
		<p class="cleafix show-for-small-only"></p>
	</div>
	<form enctype="multipart/form-data" id="form_admin" action="{$form->getAction()}" method="post" data-abide>
		<div class="small-12 columns">
			<div class="show-for-medium-up">
				<ul class="tabs" data-tab>
					<li class="tab-title active"><a href="#geral">Pendente</a></li>
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
							<li class="active"><a href="#geral">Pendente</a></li>
						</ul>
					</section>
				</nav>
			</div>
			<div class="tabs-content">
				<div class="content active" id="geral">
					<div class="apontamentos-container">
						<h2 class="titulo">último Apontamento Feito:</h2>
						<hr>
						{if $apontamentos}
							<p class="text-apontamentos">{$apontamentos}</p>	
						{else}
							<p class="text-apontamentos-null">Sem apontamentos!</p>	
						{/if}
					</div>
					<hr>
					{$form}
				</div>
			</div>
		</div>
	</form>
</div>
