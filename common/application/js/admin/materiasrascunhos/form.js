$(function() {


    $(document).ready(function() {

        $("#salvarComoRascunho").prop("disabled", false);

        $("#isRascunho").change(() => {
            const radio = document.getElementById('isRascunhoRascunho');
            if (radio.checked) {
                $("#salvarComoRascunho").removeClass("hidden");
                $("#enviarParaAprovacao").addClass("hidden");
            } else {
                $("#salvarComoRascunho").addClass("hidden");
                $("#enviarParaAprovacao").removeClass("hidden");
            }
        });
    });
});