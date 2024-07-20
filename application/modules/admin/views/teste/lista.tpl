<div class="row">	
	<div class="small-12 columns buttons-bar">
		<ul class="stack-for-small button-group">
			{assign var="url" value=$this->CreateUrl("cadastro", NULL, NULL, [])}
			<li>
				<a href="{$url}" class="button btn-new"><i class="mdi mdi-plus-circle-outline"></i> Novo</a>
			</li>
			<li>
				<a href="javascript:void(0);" class="button btn-view secondary"><i class="mdi mdi-eye"></i> Visualizar</a>
			</li>
		</ul>
	</div>
</div>

{assign var="urldata" value=$this->CreateUrl("cadastro", NULL, NULL, [])|cat:'/id/'}

<div class="row">
	<div class="small-12 columns">
		<div class="table-list">
			<table class="responsive list">
				<thead>
					<tr>
						<th width="100">
							<div class="listcheckbox">
								<input type="checkbox" value="" id="selecionatodoslist" class="selecionatodoslist"><label for="selecionatodoslist"></label>
							</div>
							#
						</th>
						<th>Título</th>
						<th>Data</th>
						<th width="50"></th>
					</tr>
				</thead>
				
				<tbody>
					{if $registros|count > 0}
						{foreach from=$registros item="row"}
							{assign var="urleditar" value=$urldata|cat:$row['id']|utf8_encode}

							<tr data-editar="{$urleditar}">
								<td width="100">
									<div class="listcheckbox">
										<input type="checkbox" value="{$row['id']}" id="{$primary}_{$row['id']}" name="id"><label for="{$primary}_{$row['id']}"></label>
									</div>
									<span class="showId">{$row['id']}</span>
								</td>

								<td>{$row['titulo']}</td>

								<td>{$row['data']}</td>

								<td class="coluna-acoes">
									<a href="{$urleditar}" title="Cadastro"><i class="mdi mdi-printer btn-visualizar-individual"></i></a>
								</td>
							</tr>
						{/foreach}
					{else}
						<tr><td colspan="4" style="text-align:center; color:#FF0000;"><b>Nenhum registro encontrado</b></td></tr>
					{/if}
				</tbody>
			</table>
		</div>
	</div>

	<div class="small-12 columns">
		<div class="footer-bar">
			{*$this->paginationControl($paginator, NULL, 'paginator.tpl')*}
		</div>
	</div>

</div>
