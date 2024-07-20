<div class="row">
	<div class="small-12 columns buttons-bar">
		<ul class="stack-for-small button-group">
			<li>
				<a href="{$this->url(['module'=>'admin', 'controller'=>'teste', 'action'=>'lista'], 'default', TRUE)}{$filtrosParam}" class="button secondary normal">
					<span class="mdi mdi-backburger"></span> Voltar para listagem
				</a>
			</li>

			<li>
				<button form="form_admin" type="submit" name="submit" value="true" onclick="$('#'+this.getAttribute('form')).submit();" disabled>
					<span class="mdi mdi-content-save-move-outline"></span> Cadastrar
				</button>
			</li>
		</ul>
		<p class="cleafix show-for-small-only"></p>
	</div>

	<form enctype="multipart/form-data" id="form_admin" action="#" method="post" data-idprimary="{$id}" data-abide>
		<div class="small-12 columns">
			<div class="show-for-medium-up">
				<ul class="tabs" data-tab data-options="deep_linking:true">
					<li class="tab-title active"><a href="#geral">GERAL</a></li>
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
							<li class="active"><a href="#geral">GERAL</a></li>
						</ul>
					</section>
				</nav>
			</div>
			<div class="tabs-content">
				<div class="content active" id="geral">
					{foreach from=$data key="name" item="value"}
						<div class="element-form" id="element-{$name}">
							<div class="row">
								<div class="small-12 medium-12 large-12 columns labeldiv" id="label-{$name}"><label for="{$name}" class="required">{$name|mb_strtoupper} <small> </small></label></div>
								<div class="input-form small-12 medium-4 large-5 columns end">
									<input type="text" name="{$name}" id="{$name}" value="{$value}" field-type="text" class="varchar string radius" required="" data-ac_label="" aria-invalid="false">
								</div>
							</div>
						</div>
					{/foreach}
				</div>
			</div>
		</div>
		
		{if $id|default:0 > 0}
			<input type=hidden name="referer_url" value="{$this->url(['module'=>'admin', 'controller'=>$controller, 'action'=>'lista'], 'default', FALSE)}">
		{/if}
	</form>
</div>
