$(function() {
	//$( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
});

function getMonth(mes) {

	var mes_atual = parseInt(mes);

	if(mes_atual == 0) {
		mes_atual = 12;
	}

	if(mes_atual == 13) {
		mes_atual = 1;
	}

	switch(mes_atual) {
		case 1:
			mes_atual = "Janeiro";
			break;
		case 2:
			mes_atual = "Fevereiro";
			break;
		case 3:
			mes_atual = "Março";
			break;
		case 4:
			mes_atual = "Abril";
			break;
		case 5:
			mes_atual = "Maio";
			break;
		case 6:
			mes_atual = "Junho";
			break;
		case 7:
			mes_atual = "Julho";
			break;
		case 8:
			mes_atual = "Agosto";
			break;
		case 9:
			mes_atual = "Setembro";
			break;
		case 10:
			mes_atual = "Outubro";
			break;
		case 11:
			mes_atual = "Novembro";
			break;
		case 12:
			mes_atual = "Dezembro";
			break;
	}

	return mes_atual;
}