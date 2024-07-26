
<style>

	body, html {
		margin: 0;
		padding: 0;
		box-sizing: border-box;
	}

	.print-programacao-radio {
		background-color: rgb(245, 245, 245);
		display: flex;
		justify-content: center;
		padding: 50px 0;
	}

	.item {
		width: 800px;
	}

	.item .valor {
		font-family: sans-serif;
		font-weight: 500;
	}
</style>

<div class="print-programacao-radio">
	<div class="item">
		{foreach $dados as $column=>$value}
			<h2 class="valor">
				<span class="coluna">{$column}</span>
				<span class="decoracao">:</span>
				<span class="valor">{$value}</span>
			</h2>
		{/foreach}
	</div>
</div>
