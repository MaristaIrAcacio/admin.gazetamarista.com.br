<div class="row">	
	<div class="small-12 columns buttons-bar">
		<ul class="stack-for-small button-group">
			{assign var="url" value=$this->CreateUrl("form", NULL, NULL, [])}
			{if $somenteview != true}
				{if $esconderBtnNovo != true}
					<li>
						<a href="{$url}" class="button btn-new">
							<i class="mdi mdi mdi-plus"></i> Novo
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

			{if $esconderBtnFiltrar != true}
				<li class="btn-filtro">
					<a class="button " data-reveal-id="filtros">
						<i class="mdi mdi-filter-outline"></i> Filtrar
					</a>
				</li>
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

{if $somenteview}
	{assign var="urldata" value=$this->CreateUrl("view", NULL, NULL, [])|cat:'/'|cat:$primary|cat:'/'}
{else}
	{assign var="urldata" value=$this->CreateUrl("form", NULL, NULL, [])|cat:'/'|cat:$primary|cat:'/'}
{/if}

{assign var="urldatavisualizar" value=$this->CreateUrl("view", NULL, NULL, [])|cat:'/'|cat:$primary|cat:'/'}

{assign var="urldataimprimir" value=$this->CreateUrl("print", NULL, NULL, [])|cat:'/id/'}

<div class="row">
	<div class="small-12 columns">
		<div class="table-list">
			<table class="responsive list">
				<thead>
					<tr>
						<th width="100">
							<div class="listcheckbox">
								<input type="checkbox" value="" id="selecionatodoslist" class="selecionatodoslist">
								<label for="selecionatodoslist"></label>
							</div>
							#
						</th>
						{foreach $_model->getCampo() as $column=>$value}
							{if $_model->getVisibility($column, 'list')}
								<th>
									{$value}
								</th>
							{/if}
						{/foreach}
						<th width="50"></th>
					</tr>
				</thead>
				
				<tbody>
					{if $paginator|count > 0}
						{foreach from=$paginator item="row"}
							{assign var="urleditar" value=$urldata|cat:$row[$primary]|utf8_encode}
							{assign var="urlvisualizar" value=$urldatavisualizar|cat:$row[$primary]|utf8_encode}
							{assign var="urlimprimir" value=$urldataimprimir|cat:$row[$primary]|utf8_encode}

							<tr data-editar="{$urleditar}" data-visualizar="{$urlvisualizar}" class="{if isset($row->ativo)}{if $row->ativo == 0}tr_inativa{/if}{/if}">
								<td width="100">
									<div class="listcheckbox">
										<input type="checkbox" value="{$row[$primary]}" id="{$primary}_{$row[$primary]}" name="{$primary}"/>
										<label for="{$primary}_{$row[$primary]}"></label>
									</div>
									<span class="showId">{$row[$primary]}</span>
								</td>

								{foreach $_model->getCampo() as $column=>$value}
									{assign var="conteudo_campo" value=$this->GetColumnValue($row, $column)}
									{if $_model->getVisibility($column, 'list')}
										<td>
											{$conteudo_campo|strip_tags|truncate:200:"..."}
										</td>
									{/if}
								{/foreach}

								<td class="coluna-acoes" >
									<a href="{$urlimprimir}" target="_blank" title="Visualizar"><i class="mdi mdi-printer btn-visualizar-individual"></i> </a>

									{assign var="urlexcluirindividual" value=$this->CreateUrl("delete", NULL, NULL, [])|cat:'/'|cat:$primary|cat:'/'}
									{if $_permitidoExcluir}
										{if $esconderBtnRemover != true}
											<a href="{$urlexcluirindividual|utf8_encode}" class="btn-remove-invidual" title="Excluir" data-id="{$row[$primary]}"><i class="mdi mdi-trash-can-outline btn-deletar-individual"></i></a>
										{/if}
									{/if}
								</td>
							</tr>
						{/foreach}
					{else}
						<tr><td colspan="10" style="text-align:center; color:#FF0000;"><b>Nenhum registro encontrado</b></td></tr>
					{/if}
				</tbody>
			</table>
		</div>
	</div>

	<div class="small-12 columns">
		<div class="footer-bar">
			{$this->paginationControl($paginator, NULL, 'paginator.tpl')}
		</div>
	</div>

</div>