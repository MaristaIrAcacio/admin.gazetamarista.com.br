<ul class="breadcrumbs">
    <li>
    	<a href="{$this->url(['module'=>'admin', 'controller'=>'index', 'action'=>'index'], 'default', TRUE)}">Painel Admin</a>
    </li>

	{if $this->pages|count > 0}
		{assign var="page_name" value=''}
		{foreach $this->pages as $key => $page}
			{if $key < count($this->pages) - 1}
				<li class="unavailable">
					{$page->getLabel()}
				</li>
			{else}
				<li>
					<a href="{$page->getHref()|replace:'/form':'/list'}">{$page->getLabel()}</a>
				</li>
			{/if}
			{assign var="page_name" value=$page->getLabel()}
		{/foreach}
	{else}
		<li class="unavailable">
			{$this->breadcrumb('menuitem-categoria')}
		</li>

		{if !empty($controller)}
			<li>
				<a href="{$this->url(['module'=>'admin', 'controller'=>$controller, 'action'=>'list'], 'default', TRUE)}">{$this->breadcrumb('menuitem-descricao')}</a>
			</li>
		{/if}
	{/if}
</ul>

{if !empty($page_name)}
	<h2 style="text-transform: capitalize;">
		{$page_name} {if $paginator}<span style="font-size:13px;">(Total itens: {$paginator->getTotalItemCount()})</span>{/if} {if $qtd_registros}<span style="font-size:13px;">(Total itens: {$qtd_registros})</span>{/if}
	</h2>
{/if}
