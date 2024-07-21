$(function() {

    $("#salvarComoRascunho").prop("disabled", true);

    $(document).ready(function() {

        $("#salvarComoRascunho").prop("disabled", false);

        $("#isRascunho").change(() => {
            $("#salvarComoRascunho").toggleClass("hidden");
            $("#enviarParaAprovacao").toggleClass("hidden");
        });
    });
});