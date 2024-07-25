<div class="row">
	<div class="small-12 columns buttons-bar">
		<ul class="stack-for-small button-group">
			<li>
				<a href="{$this->url(['module'=>'admin', 'controller'=>$controller, 'action'=>'list'], 'default', TRUE)}{$filtrosParam}" class="button secondary normal">
					<span class="mdi mdi-backburger"></span> Voltar para listagem
				</a>
			</li>

			<li>
				<button id="enviarParaAprovacao" style="display: flex;gap: 10px; align-items: center;" form="form_admin" type="submit" name="submit" onclick="$('#'+this.getAttribute('form')).submit();">
					<span class="mdi mdi-content-save"></span>Enviar Para Aprovação
				</button>
			</li>
		</ul>
		<p class="cleafix show-for-small-only"></p>
	</div>

	<form enctype="multipart/form-data" id="form_admin" action="{$form->getAction()}" method="post" data-idprimary="{$id}" data-abide>	
		<div class="small-12 columns">
			<div class="show-for-medium-up">
				<ul class="tabs" data-tab data-options="deep_linking:true">
					{if !empty($_tabs)}
						{foreach from=$_tabs key="key" item="_tab"}
							<li class="tab-title {if $key == 0}active{/if}"><a href="#{$_tab['url']|lower}">{$_tab['name']|capitalize}</a></li>
						{/foreach}
					{/if}
					{if !empty($_tabscompletas)}
						{foreach from=$_tabscompletas key="key" item="_tabcompleta"}
							<li class="tab-title {if $key == 0 && empty($_tabs)}active{/if}"><a href="#{$_tabcompleta['url']|lower}">{$_tabcompleta['name']|capitalize}</a></li>
						{/foreach}
					{/if}
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
							{if !empty($_tabs)}
								{foreach from=$_tabs key="key" item="_tab"}
									<li class="{if $key == 0}active{/if}"><a href="#{$_tab['url']|lower}">{$_tab['name']|capitalize}</a></li>
								{/foreach}
							{/if}
							{if !empty($_tabscompletas)}
								{foreach from=$_tabscompletas key="key" item="_tabcompleta"}
									<li class="{if $key == 0 && empty($_tabs)}active{/if}"><a href="#{$_tabcompleta['url']|lower}">{$_tabcompleta['name']|capitalize}</a></li>
								{/foreach}
							{/if}
						</ul>
					</section>
				</nav>
			</div>
			<div class="tabs-content">
				{if !empty($_tabs)}
					{foreach from=$_tabs key="key" item="_tab"}
						<div class="content {if $key == 0}active{/if}" id="{$_tab['url']|lower}">
							{foreach from=$form->getElements() item="element"}
								{if $element->getName() != "submit" && $element->getName() != "cancel"}
									{if $_tab['url']|lower == $element->tab|lower}
										{$element}
									{else}
										{if $element->tab|lower == null && $key == 0}
											{$element}
										{/if}
									{/if}
								{/if}
							{/foreach}
						</div>
					{/foreach}
				{else}
					<div class="content active">
						{foreach from=$form->getElements() item="element"}
							{if $element->getName() != "submit" && $element->getName() != "cancel"}
								{$element}
							{/if}
						{/foreach}
					</div>
				{/if}
				
				{* TABS DINAMICAS NÃO UTILIZADAS (COMO ADICIONAR TABS DINÂMICAS?) *}
				{* COMO UTILIZAR A VARIAVEL "$_tabs"? *}

				{foreach from=$_tabscompletas item="_tabcompleta"}
					<div class="content" id="{$_tabcompleta['url']|lower}">
						{assign var=Condicao value="`$TableName`.`$primary`"}
						{assign var=_tab_list value=$_tabcompleta['model']->fetchAll($_tabcompleta['select']->where($Condicao|cat:' = ?', $id))}
						{assign var=_tab_primary value=current($_tabcompleta['model']->getPrimaryField())}
						{assign var=_tab_infos value=$_tabcompleta['model']->info()}
						{assign var=_tab_columns value=$_tabcompleta['model']->getCampo()}

						<table width="100%" cellpadding="0" cellspacing="0" class="list">
							<thead>
								<tr>
									<th>#</th>
									{foreach $_tab_list->current() as $column => $value}
										{if $_tabcompleta['model']->getVisibility($column, 'list')}
											<th>
												{$_tab_columns[$column]}
											</th>
										{/if}
									{/foreach}
								</tr>
							</thead>
							<tbody>
								{foreach from=$_tab_list item="_tab_row"}
									<tr>
										<td>
											{$_tab_row[$_tab_primary]}
										</td>
									</tr>
								{/foreach}
							</tbody>
						</table>
					</div>
				{/foreach}
			</div>
		</div>
		
		{if $id|default:0 > 0}
			<input type=hidden name="referer_url" value="{$this->url(['module'=>'admin', 'controller'=>$controller, 'action'=>'list'], 'default', FALSE)}">
		{/if}
	</form>
</div>
