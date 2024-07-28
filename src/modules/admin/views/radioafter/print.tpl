
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
	<h1>{$dados.Data}</h1>
	<div class="item">
		{*{foreach $dados as $column=>$value}
			<h2 class="valor">
				<span class="coluna">{$column}</span>
				<span class="decoracao"> - </span>
				<span class="valor">{$value}</span>
			</h2>
		{/foreach} *}

		{* <h2 class="valor">
			<span class="locutor-1">{$dados.Locutor1}</span>
			<span class="decoracao"> - </span>
			<span class="valor">Bom dia, estudantes, colaboradores e comunidade. Eu sou {$dados.Locutor1}.</span>
		</h2>

		<h2 class="valor">
			<span class="locutor-2">{$dados.Locutor2}</span>
			<span class="decoracao"> - </span>
			<span class="valor">Eu sou {$dados.Locutor2}.</span>
		</h2>

		<h2 class="valor">
			<span class="locutor-3">{$dados.Locutor3}</span>
			<span class="decoracao"> - </span>
			<span class="valor">E eu sou {$dados.Locutor3}, e estaremos com vocês nas ondas da nossa rádio até às 10:30.</span>
		</h2> *}

		{$dados.pauta_escrita}

	</div>
</div>
