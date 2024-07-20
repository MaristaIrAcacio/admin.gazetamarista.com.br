<nav class="pagination-container">
	<ul class="uk-pagination uk-flex-center uk-margin-medium-top" uk-margin>
		{foreach from=$pagesInRange item="page"}
			{if $page != $this->current}
				<li><a href="{$this->url(['page' => $page])}" aria-label="Ir para página {$page}">{$page}</a></li>
			{else}
				<li class="uk-active" aria-current="page"><a>{$page}</a></li>
			{/if}
		{/foreach}
	</ul>
</nav>
