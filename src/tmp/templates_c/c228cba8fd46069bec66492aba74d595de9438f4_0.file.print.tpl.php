<?php
/* Smarty version 3.1.36, created on 2024-07-27 17:33:02
  from 'c:\xampp-7.4\htdocs\admin.gazetamarista.com.br\application\modules\admin\views\radio\print.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_66a5597e7dcd55_19135085',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c228cba8fd46069bec66492aba74d595de9438f4' => 
    array (
      0 => 'c:\\xampp-7.4\\htdocs\\admin.gazetamarista.com.br\\application\\modules\\admin\\views\\radio\\print.tpl',
      1 => 1722045783,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_66a5597e7dcd55_19135085 (Smarty_Internal_Template $_smarty_tpl) {
?>
<style>

	@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');

	body, html {
		margin: 0;
		padding: 0;
		box-sizing: border-box;
		background-color: rgb(245, 245, 245);
		display: flex;
		justify-content: center;
		align-items: center;
	}

	* {
		font-family: "Roboto", sans-serif;
	}

	.print-programacao-radio {
		background-color: #fff;
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		padding: 50px 0;
		width: 900px;
		padding: 0 50px;
		padding-top: 60px;
	}

	.topo {
		width: 100%;
		display: flex;
		flex-direction: column;
		align-items: center;
		margin: 0;		
	}

	.topo > .titulo {
		font-size: 22px;
		background-color: red;
		padding: 5px;
		color: #fff;
		border-radius: 4px;
		margin: 0;
		text-align: center;
	}

	.topo > .slogan {
		font-size: 22px;
		background-color: yellow;
		padding: 5px;
		color: #000;
		font-weight: 700;
		border-radius: 4px;
		margin: 0;
		text-align: center;
	}

	.tipo-texto {
		margin: 40px 10px 10px 10px;
		font-size: 22px;
		font-weight: 600;
		text-align: center;
	}

	.comando-locutor {
		font-size: 24px;
		font-weight: 700;
		text-align: center;
	}

	.item {
		width: 800px;
	}

	.valor {
		font-size: 22px;
		font-weight: 600;
		line-height: 34px;
	}

	.locutor-1 {
		background-color: #4a87e2;
		padding: 4px 6px;
		border-radius: 4px;
	}

	.locutor-2 {
		background-color: #fa01ff;
		padding: 4px 6px;
		border-radius: 4px;
	}

	.locutor-3 {
		background-color: #fd9a00;
		padding: 4px 6px;
		border-radius: 4px;
	}
</style>

<div class="print-programacao-radio">
	<header class="topo">
		<h1 class="titulo">PROGRAMAÇÃO RÁDIO CONEXÃO</h1>
		<p class="tipo-texto">Slogan:</p>
		<p class="slogan">"Ampliando vozes, conectando comunidades, a rádio da nossa escola é o som que une e inspira."</p>
		<h5 class="comando-locutor">LOCUTORES: SOLTEM A VINHETA DE ABERTURA, APÓS ELA SIGAM O ROTEIRO ABAIXO!</h5>
	</header>
	<h1><?php echo $_smarty_tpl->tpl_vars['dados']->value['Data'];?>
</h1>
	<div class="item">
		
		
		<?php echo $_smarty_tpl->tpl_vars['dados']->value['pauta_escrita'];?>


	</div>
</div>
<?php }
}
