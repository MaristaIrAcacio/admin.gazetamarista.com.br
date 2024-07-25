<div class="row">	
	<div class="small-12 columns buttons-bar">
		<ul class="stack-for-small button-group">
			{assign var="url" value=$this->CreateUrl("form", NULL, NULL, [])}
			{if $somenteview != true}
				{if $esconderBtnNovo != true}
					<li>
						<a href="{$url}" class="button btn-new">
							<i class="mdi mdi-plus-circle-outline"></i> Nova Charge
						</a>
					</li>
				{/if}
			{/if}
			{if $paginator|count > 0}
				{if $esconderBtnVisualizar != true}
					<li>
						<a href="javascript:void(0);" class="button btn-view secondary">
							<i class="mdi mdi-eye"></i> Visualizar
						</a>
					</li>
				{/if}
			
				{assign var="urldata" value=$this->CreateUrl("delete", NULL, NULL, [])|cat:'/'|cat:$primary|cat:'/'}
				{if $_permitidoExcluir}
					{if $esconderBtnRemover != true}
						<li>
							<a href="{$urldata|utf8_encode}" class="button btn-remove alert">
								<i class="mdi mdi-delete"></i> Remover
							</a>
						</li>
					{/if}
				{/if}
			{/if}

			{if $paginator|count > 0}
				{if $gerarxls !== false}
					<li class="exportxls">
						<a href="{$this->url(['module'=>'admin', 'controller'=>$controller, 'action'=>'exportarxls'], 'default', TRUE)}{$filtrosParam}" target="_blank" class="button">
							<i class="mdi mdi-file-excel"></i> Exportar lista (xls)
						</a>
					</li>
				{/if}
			{/if}
		</ul>
	</div>
	
	{if $esconderBtnFiltrar != true}
		<div id="filtros" class="reveal-modal" data-reveal aria-labelledby="Filtros" aria-hidden="true" role="dialog">
			<h2>Filtrar </h2>
			<form action="{$this->url(['module'=>'admin', 'controller'=>$controller, 'action'=>'search', {key($requireParam)}, {current($requireParam)}], 'default', TRUE)}" method="post">
				<div class="row">
					{foreach $_model->getCampo() as $column=>$value}
						{if $_model->getVisibility($column, 'list') || $_model->getVisibility($column, 'search')}
							{$form->getElement($column)}
						{/if}
					{/foreach}
					<p class="clearfix"></p>
				</div>
				
				<div class="row">
					<div class="small-12 medium-2 columns">
						<button type="submit" class="expand">Buscar</button>
					</div>
					<div class="small-12 medium-2 end columns">
						<button type="reset" class="input-reset-search expand button secondary normal" data-url="{$basePath}/admin/{$currentController}/list" ><span class="mdi mdi-backburger"></span> Limpar</button>
					</div>
				</div>
			</form>
			<a class="close-reveal-modal" aria-label="Close">&#215;</a>
		</div>
	{/if}
</div>

{if $listExtraIcons|count > 0}
	<div class="row">
		<div class="small-12 columns">
			{foreach from=$listExtraIcons item="icon"}
				<a class="{$icon['class']}" href="{$this->url($icon['url'], 'default', $icon['clear'])}">{$icon['value']}</a>
			{/foreach}
		</div>
	</div>
{/if}