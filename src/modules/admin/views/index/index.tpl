<!-- Carregar jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Carregar Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{if $logged_usuario['idperfil'] > 0}
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
        <br><br><hr><br><br>
        <div class="row-graphs">
            <section class="graph-container">
                <h1 class="titulo-graph">Matérias por Categoria</h1>
                <canvas id="graph_categorias_materias" width="400" height="200"></canvas>
            </section>
            <section class="graph-container">
                <h1 class="titulo-graph">Status das Matérias</h1>
                <canvas id="graph_status_materias" width="400" height="200"></canvas>
            </section>
        </div>
        <br><br><hr><br><br>
        <div class="row-graphs">
            <section class="graph-container">
                <h1 class="titulo-graph">Colaborações por Usuário (Top #10)</h1>
                <canvas id="graph_colaboracoes_por_usuario" width="400" height="200"></canvas>
            </section>
        </div>
        <hr>

    </div>
    {/if}

    <script>
        // Passa os dados do Smarty para o JavaScript
        const dados_materias_por_turma = JSON.parse('{$grapf_materias_por_turma|escape:"js"}');

        // Cria o OBJETO 2d para renderização
        const ctx_graph_1 = document.getElementById('graph_materias_por_turma').getContext('2d');

        // Define a Instância do Gráfico
        new Chart(ctx_graph_1, {
            type: 'bar',
            data: dados_materias_por_turma,
            options: { 
                scales: { 
                    y: { 
                        beginAtZero: true 
                    } 
                } 
            }
        });

        // =================================================================================

        // Passa os dados do Smarty para o JavaScript
        const dados_charges_por_turma = JSON.parse('{$grapf_charges_por_turma|escape:"js"}');

        // Cria o OBJETO 2d para renderização
        const ctx_graph_2 = document.getElementById('graph_charges_por_turma').getContext('2d');

        // Define a Instância do Gráfico
        new Chart(ctx_graph_2, {
            type: 'bar',
            data: dados_charges_por_turma,
            options: { 
                scales: { 
                    y: { 
                        beginAtZero: true 
                    } 
                } 
            }
        });

        // =================================================================================

        // Passa os dados do Smarty para o JavaScript
        const dados_categorias_materias = JSON.parse('{$graph_categorias_materias|escape:"js"}');

        // Cria o OBJETO 2d para renderização
        const ctx_graph_categorias = document.getElementById('graph_categorias_materias').getContext('2d');

        // Define a Instância do Gráfico
        new Chart(ctx_graph_categorias, {
            type: 'pie',
            data: dados_categorias_materias,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                let label = tooltipItem.label || '';
                                let value = tooltipItem.raw || 0;
                                return label + ': ' + value;
                            }
                        }
                    }
                }
            }
        });

        // ====================================================================================================
        // Passa os dados do Smarty para o JavaScript
        const dados_colaboracoes_por_usuario = JSON.parse('{$graph_colaboracoes_por_usuario|escape:"js"}');

        // Cria o OBJETO 2d para renderização
        const ctx_graph_colaboracoes = document.getElementById('graph_colaboracoes_por_usuario').getContext('2d');

        // Define a Instância do Gráfico
        new Chart(ctx_graph_colaboracoes, {
            type: 'bar',
            data: dados_colaboracoes_por_usuario,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                let label = tooltipItem.label || '';
                                let value = tooltipItem.raw || 0;
                                return label + ': ' + value;
                            }
                        }
                    }
                }
            }
        });


        // =========================================================================================================
        // Passa os dados do Smarty para o JavaScript
        const dados_status_materias = JSON.parse('{$graph_status_materias|escape:"js"}');

        // Cria o OBJETO 2d para renderização
        const ctx_graph_status = document.getElementById('graph_status_materias').getContext('2d');

        // Define a Instância do Gráfico
        new Chart(ctx_graph_status, {
            type: 'doughnut',
            data: dados_status_materias,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                let label = tooltipItem.label || '';
                                let value = tooltipItem.raw || 0;
                                return label + ': ' + value;
                            }
                        }
                    }
                }
            }
        });


    </script>