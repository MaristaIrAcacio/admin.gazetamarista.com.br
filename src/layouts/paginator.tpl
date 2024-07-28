<div class="pagination-centered">
	<ul class="pagination">
		
		<li><a {if isset($previous)}href="{$this->url(['page' => $previous])}"{/if} class="no-border">&lsaquo;</a></li>
		
		
		{foreach from=$pagesInRange item=page}
			{if $page != $this->current}
				<li><a href="{$this->url(['page' => $page])}">{$page}</a></li>
			{else}
				<li class="current"><a href="{$this->url(['page' => $page])}">{$page}</a></li>
			{/if}
		{/foreach}
		
		
		<li><a {if isset($next)}href="{$this->url(['page' => $next])}"{/if} class="no-border">&rsaquo;</a></li>
		
	</ul>
</div>