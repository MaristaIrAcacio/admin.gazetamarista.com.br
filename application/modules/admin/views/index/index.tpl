{if $logged_usuario['idperfil'] > 2}
	<div class="row" id="container">
		{* <div class="columns dasboard-list" id="sortable">

			<div class="blocoNumeros ui-state-default">
				<h5><i class="mdi mdi-cursor-move"></i> Total Geral</h5>

				<div class="BlocoNumero BlocoLaranja">
					<i class="mdi mdi-cellphone-information"></i>
					<div class="Dados">
						<h4>{$resumo['qtd_contato']}</h4>
						<span>Contato{if $resumo['qtd_contato'] > 1}s{/if}</span>
					</div>
				</div>
				<div class="BlocoNumero BlocoVerde">
					<i class="mdi mdi-email"></i>
					<div class="Dados">
						<h4>{$resumo['qtd_email']}</h4>
						<span>E-mail{if $resumo['qtd_email'] > 1}s{/if}</span>
					</div>
				</div>
				<div class="BlocoNumero BlocoAmarelo">
					<i class="mdi mdi-toolbox-outline"></i>
					<div class="Dados">
						<h4>{$resumo['qtd_servicos']}</h4>
						<span>Serviço{if $resumo['qtd_servicos'] > 1}s{/if}</span>
					</div>
				</div>
				<div class="BlocoNumero BlocoAzul">
					<i class="mdi mdi-newspaper-variant-outline"></i>
					<div class="Dados">
						<h4>{$resumo['qtd_noticias']}</h4>
						<span>Notícia{if $resumo['qtd_noticias'] > 1}s{/if}</span>
					</div>
				</div>
			</div>

			<div class="bloco ui-state-default">
				<h5><i class="mdi mdi-cursor-move"></i> Últimos Contatos</h5>
				<table class="list">
					<tbody>
                    {if $contatos|count > 0}
                        {foreach from=$contatos item="row"}
                            <tr data-link="{$basePath}/admin/contatos/view/idcontato/{$row['idcontato']}">
                                <td>#{$row['idcontato']}</td>
                                <td>{$row['nome']}</td>
                                <td>{$row['email']}</td>
                                <td>{$this->dateformat("%d/%m/%Y", $row['data'])}</td>
                            </tr>
                        {/foreach}
                        <tr data-link="{$basePath}/admin/contatos/list"><td class="verlista" colspan="3"><i class="mdi mdi-format-list-bulleted"></i> Ver Listagem</td></tr>
                    {else}
                        <tr><td colspan="4" style="text-align: center; color: red;">Nenhum item encontrado.</td></tr>
                    {/if}
					</tbody>
				</table>
			</div>

			<div class="bloco ui-state-default">
				<h5><i class="mdi mdi-cursor-move"></i> Últimos E-mails</h5>
				<table class="list">
					<tbody>
                    {if $emails|count > 0}
                        {foreach from=$emails item="row"}
                            <tr data-link="{$basePath}/admin/emails/view/idemail/{$row['idemail']}">
                                <td>#{$row['idemail']}</td>
                                <td>{$row['email']}</td>
                                <td>{$this->dateformat("%d/%m/%Y", $row['data'])}</td>
                            </tr>
                        {/foreach}
                        <tr data-link="{$basePath}/admin/emails/list"><td class="verlista" colspan="4"><i class="mdi mdi-format-list-bulleted"></i> Ver Listagem</td></tr>
                    {else}
                        <tr><td colspan="3" style="text-align: center; color: red;">Nenhum item encontrado.</td></tr>
                    {/if}
					</tbody>
				</table>
			</div>

			<div class="bloco ui-state-default">
				<h5><i class="mdi mdi-cursor-move"></i> Últimas notícias</h5>
				<table class="list">
					<tbody>
                    {if $blogs|count > 0}
                        {foreach from=$blogs item="row"}
                            <tr data-link="{$basePath}/admin/blogs/view/idblog/{$row['idblog']}">
                                <td>#{$row['idblog']}</td>
                                <td>{$row['titulo']}</td>
                                <td>{$row['autor']}</td>
                                <td>{$this->dateformat("%d/%m/%Y", $row['data'])}</td>
                            </tr>
                        {/foreach}
                        <tr data-link="{$basePath}/admin/blogs/list"><td class="verlista" colspan="3"><i class="mdi mdi-format-list-bulleted"></i> Ver Listagem</td></tr>
                    {else}
                        <tr><td colspan="4" style="text-align: center; color: red;">Nenhum item encontrado.</td></tr>
                    {/if}
					</tbody>
				</table>
			</div>

			<div class="bloco ui-state-default">
				<h5><i class="mdi mdi-cursor-move"></i> Últimos Serviços</h5>
				<table class="list">
					<tbody>
                    {if $servicos|count > 0}
                        {foreach from=$servicos item="row"}
                            <tr data-link="{$basePath}/admin/servicos/view/idemail/{$row['idservico']}">
                                <td>#{$row['idservico']}</td>
                                <td>{$row['titulo']}</td>
                            </tr>
                        {/foreach}
                        <tr data-link="{$basePath}/admin/servicos/list"><td class="verlista" colspan="4"><i class="mdi mdi-format-list-bulleted"></i> Ver Listagem</td></tr>
                    {else}
                        <tr><td colspan="3" style="text-align: center; color: red;">Nenhum item encontrado.</td></tr>
                    {/if}
					</tbody>
				</table>
			</div>
		</div> *}
	</div>
{/if}
