$(function() {
    $(document).ready(function() {
        if (CKEDITOR.instances.pauta_escrita) {
            var editor = CKEDITOR.instances.pauta_escrita;
            var currentData = editor.getData();

            // Verifica se o editor está vazio
            if (!currentData.trim()) {
                editor.setData(`
                    <p><strong>LOCUTORES:</strong><br />
                    Soltem a vinheta de abertura. Após ela, sigam o roteiro abaixo!</p>

                    <p><strong>LOCUTOR 1:</strong><br />
                    Bom dia, estudantes, colaboradores e comunidade. Eu sou ____.</p>

                    <p><strong>LOCUTOR 2:</strong><br />
                    Eu sou ___.</p>

                    <p><strong>LOCUTOR 3:</strong><br />
                    E eu sou ____, e estaremos com vocês nas ondas da nossa rádio até às 10:30.</p>

                    <p><strong>CALENDÁRIO SAZONAL</strong><br />
                    <strong>LOCUTOR 1:</strong><br />
                    (Calendário sazonal aqui...)</p>

                    <p><strong>LOCUTOR 2:</strong><br />
                    E vamos agora para nossa primeira faixa do dia!</p>

                    <p><strong>MÚSICA 1:</strong><br />
                    (Primeira&nbsp;música do dia aqui...)</p>

                    <p><strong>LOCUTOR 1:</strong><br />
                    Você ouviu ___.</p>

                    <p><strong>NOTÍCIA</strong><br />
                    <strong>LOCUTOR 2:</strong><br />
                    (Primeira Notícia aqui)</p>

                    <p><strong>LOCUTOR 3:</strong><br />
                    E vamos pra nossa próxima faixa!</p>

                    <p><strong>MÚSICA 2:</strong><br />
                    (Segunda música aqui)</p>

                    <p><strong>LOCUTOR 2:</strong><br />
                    Você escutou ___.</p>

                    <p><strong>CURIOSIDADE DO DIA</strong><br />
                    <strong>LOCUTOR 3:</strong><br />
                    (Curiosidade do dia aqui...)</p>

                    <p><strong>LOCUTOR 1:</strong><br />
                    E vamos de mais música!</p>

                    <p><strong>MÚSICA 3:</strong><br />
                    (Terceira música aqui)</p>

                    <p><strong>LOCUTOR 3:</strong><br />
                    Você acabou de ouvir ___.</p>

                    <p><strong>NOTÍCIA URGENTE</strong><br />
                    <strong>LOCUTOR 1:</strong><br />
                    (Insira a notícia urgente aqui)</p>

                    <p><strong>Evento após intervalo</strong></p>

                    <p><strong>LOCUTOR 1:</strong><br />
                    Mas infelizmente a nossa rádio já está chegando ao fim!</p>

                    <p><strong>LOCUTOR 2:</strong><br />
                    Muito obrigado a todos que estiveram com a gente!</p>

                    <p><strong>LOCUTOR 3:</strong><br />
                    Muito obrigado! Tenham um bom dia, um ótimo fim de semana e bons estudos! Tchau!</p>

                    <p><strong>MÚSICA 4:</strong><br />
                    (Quarta música aqui)</p>

                    <p><strong>MÚSICA 5:</strong><br />
                    (Insira a música aqui)</p>

                    <p><strong>MÚSICA 6:</strong><br />
                    (Insira a música aqui)</p>
                `);
            };
        } else {
            alert('CKEditor não está carregado.');
        }
    });
});
