$(function() {
    $("#btn-reprovar").click(() => {
        swal({
            text: 'Coloque Apontamentos para o Redator:',
            content: {
                element: 'textarea',
                attributes: {
                    className: 'custom-textarea',
                    id: 'swal-textarea'
                }
            },
            buttons: {
                cancel: 'Cancelar',
                confirm: 'Enviar'
            },
        }).then((value) => {
            if (value) {
                const apontamentos = document.getElementById('swal-textarea').value;
                
                if (apontamentos.length > 0) {
                    const inputHidden = `<input type="hidden" id="apontamentos" name="apontamentos" class="apontamentos" value="${apontamentos}">`;
                    document.getElementById('geral').innerHTML += inputHidden;
                    $('.btn-aprovar').click();
                } else {
				    swal('Ops!', 'Preencha o campo de apontamentos.', 'warning');
                };
            } else {};
        });
    });
});