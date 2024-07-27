{if $logged_usuario['idperfil'] > 2}
	<div class="row" id="container">
		<div class="row-graphs">
			<section class="graph-container">
				<h1 class="titulo-graph">Matérias Postadas por Turma</h1>
				<canvas id="graph_materias_por_turma" width="400" height="200"></canvas>
			</section>
			<section class="graph-container">
				<h1 class="titulo-graph">Charges Postadas por Turma</h1>
				<canvas id="graph_charges_por_turma" width="400" height="200"></canvas>
			</section>
		</div>
		<hr>
	</div>
{/if}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
	// Passa os dados do Smarty para o JavaScript
	const dados_materias_por_turma = JSON.parse('{$grapf_materias_por_turma|escape:"js"}');

	// Cria o OBJETO 2d para renderização
	const ctx_graph_1 = document.getElementById('graph_materias_por_turma').getContext('2d');

	// Define a Instância do Gráfico
	new Chart(ctx_graph_1, {
		type: 'bar',
		data: dados_materias_por_turma,
		options: { scales: { y: { beginAtZero: true } } }
	});


	// Passa os dados do Smarty para o JavaScript
	const dados_charges_por_turma = JSON.parse('{$grapf_charges_por_turma|escape:"js"}');

	// Cria o OBJETO 2d para renderização
	const ctx_graph_2 = document.getElementById('graph_charges_por_turma').getContext('2d');

	// Define a Instância do Gráfico
	new Chart(ctx_graph_2, {
		type: 'bar',
		data: dados_charges_por_turma,
		options: { scales: { y: { beginAtZero: true } } }
	});
</script>
