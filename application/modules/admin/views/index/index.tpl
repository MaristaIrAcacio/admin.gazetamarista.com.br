{if $logged_usuario['idperfil'] > 2}
	<div class="row" id="container">
		<h1>Matérias Postadas por Turma</h1>
    	<canvas id="myChart" width="400" height="200"></canvas>
		<br><br><br><br><br>
	</div>
{/if}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
	 // Passa os dados do Smarty para o JavaScript
	const dados = JSON.parse('{$dados|escape:"js"}');

	const ctx = document.getElementById('myChart').getContext('2d');

	new Chart(ctx, {
		type: 'bar',
		data: dados,
		options: {
			scales: {
				y: {
					beginAtZero: true
				}
			}
		}
	});
</script>
