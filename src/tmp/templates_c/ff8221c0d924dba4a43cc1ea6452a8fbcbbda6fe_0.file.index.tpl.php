<?php
/* Smarty version 3.1.36, created on 2024-07-27 19:28:55
  from 'c:\xampp-7.4\htdocs\admin.gazetamarista.com.br\application\modules\admin\views\index\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_66a574a7481669_75009108',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ff8221c0d924dba4a43cc1ea6452a8fbcbbda6fe' => 
    array (
      0 => 'c:\\xampp-7.4\\htdocs\\admin.gazetamarista.com.br\\application\\modules\\admin\\views\\index\\index.tpl',
      1 => 1722101391,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_66a574a7481669_75009108 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\xampp-7.4\\htdocs\\admin.gazetamarista.com.br\\library\\gazetamarista\\Library\\Smarty\\plugins\\modifier.escape.php','function'=>'smarty_modifier_escape',),));
?>
<!-- Carregar jQuery -->
<?php echo '<script'; ?>
 src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"><?php echo '</script'; ?>
>
<!-- Carregar Chart.js -->
<?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/chart.js"><?php echo '</script'; ?>
>

<?php if ($_smarty_tpl->tpl_vars['logged_usuario']->value['idperfil'] > 0) {?>
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
    <?php }?>

    <?php echo '<script'; ?>
>
        // Passa os dados do Smarty para o JavaScript
        const dados_materias_por_turma = JSON.parse('<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['grapf_materias_por_turma']->value, "js");?>
');

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
        const dados_charges_por_turma = JSON.parse('<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['grapf_charges_por_turma']->value, "js");?>
');

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

        
    <?php echo '</script'; ?>
><?php }
}
