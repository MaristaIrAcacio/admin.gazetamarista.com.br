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

        $('#tags').on('input', function() {
            var inputValue_tags = $(this).val();
            
            // Separar o valor por vírgulas e criar um array
            var tagsArray = inputValue_tags.split(',');
            
            // Limpar o conteúdo do contêiner
            $(".container-tags").html('');

            // Adicionar cada item ao contêiner
            tagsArray.forEach(function(item) {
                // Criar um elemento para o item e adicionar ao contêiner
                if (item.length > 0) {
                    $(".container-tags").append('<div class="tag-item">#' + item.trim() + '</div>');
                };
            });
        });
    });
});