<div class="row">
	<div class="small-12 columns buttons-bar">
		<ul class="stack-for-small button-group">
			<li>
				<a href="{$this->url(['module'=>'admin', 'controller'=>$controller, 'action'=>'list'], 'default', TRUE)}{$filtrosParam}" class="button secondary normal">
					<span class="mdi mdi-backburger"></span> Voltar para listagem
				</a>
			</li>
			{if $id > 0}
				{if $gerarpdf !== false}
					{assign var="nome_pdf" value=$controller|cat:'_cod'|cat:$id}
					<li>
						<a href="{$this->url(['module'=>'admin', 'controller'=>$controller, 'action'=>'exportpdf', 'id'=>$id, 'name'=>$nome_pdf], 'default', TRUE)}" target="_blank" class="button">
							<span class="mdi mdi-printer"></span> Imprimir
						</a>
					</li>
				{/if}
			{/if}
		</ul>
		<p class="cleafix show-for-small-only"></p>
	</div>
	
	<div id="div_all_view" class="small-12 columns">
		<div class="show-for-medium-up">
			<ul class="tabs" data-tab>
				<li class="tab-title active"></li>
				{foreach from=$_tabs item=_tab}
					<li class="tab-title"><a href="#{$_tab['name']|lower}">{$_tab['name']|capitalize}</a></li>
				{/foreach}
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
						{foreach from=$_tabs item=_tab}
							<li><a href="#{$_tab['name']|lower}">{$_tab['name']|capitalize}</a></li>
						{/foreach}
					</ul>
				</section>
			</nav>
		</div>
		<div class="tabs-content">
			<div class="content active" id="geral">
				{foreach from=$form->getElements() item=element}
					{if $element->getName() != "submit" && $element->getName() != "cancel"}
						{$element}
					{/if}
				{/foreach}
			</div>
			
			{* TABS DINAMICAS NÃO ESTILIZADAS (COMO ADICIONAR TABS DINÂMICAS?) *}
			{foreach from=$_tabs item=_tab}
				<div class="content" id="{$_tab['name']|lower}">
					{assign var=_tab_list value=$_tab['model']->fetchAll($_tab['select']->where($primary|cat:' = ?', $id))}
					{assign var=_tab_primary value=current($_tab['model']->getPrimaryField())}
					{assign var=_tab_infos value=$_tab['model']->info()}
					{assign var=_tab_columns value=$_tab['model']->getCampo()}
					
					<table width="100%" cellpadding="0" cellspacing="0" class="list">
						<thead>
							<tr>
								<th>#</th>
								{foreach $_tab_list->current() as $column => $value}
									{if $_tab['model']->getVisibility($column, 'list')}
										<th>
											{$_tab_columns[$column]}
										</th>
									{/if}
								{/foreach}
							</tr>
						</thead>
						<tbody>
						{foreach from=$_tab_list item=_tab_row}
							<tr data-url="{if count($_tab['url']) > 0}{$this->url($_tab['url'], 'default', TRUE)}/{$_tab_primary}/{$_tab_row[$_tab_primary]}{/if}">
								<td>
									{$_tab_row[$_tab_primary]}
								</td>
								{foreach $_tab_row as $column => $value}
									{if $_tab['model']->getVisibility($column, 'list')}
										<td>
											{$this->GetColumnValue($_tab_row, $column)}
										</td>
									{/if}
								{/foreach}
							</tr>
						{/foreach}
						</tbody>
					</table>
				</div>
			{/foreach}
		</div>
	</div>

	{if $id|default:0 > 0}
		<input type="hidden" name="referer_url" value="{$this->url(['module'=>'admin', 'controller'=>$controller, 'action'=>'list'], 'default', FALSE)}">
	{/if}
</div>
