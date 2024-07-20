<div class="columns fundoerro">
    {if $displayexceptions}
        <div class="error-codigo-container">
            <div class="row">
                <div class="small-12 columns">
                    <h1>An error occurred</h1>
                    <h2>{$message}</h2>

                    <h3>Exception information:</h3>
                    <p>
                        {$exception_message}
                    </p>

                    <h3>Stack trace:</h3>
                    <pre>{$trace}</pre>

                    {if isset($extras)}
                        <h3>Extras:</h3>
                        <pre>{$extras}</pre>
                    {/if}

                    <h3>Request Parameters:</h3>
                    <pre>{$params}</pre>
                </div>
            </div>
        </div>
    {/if}

    <div id="notfound">
        <div class="notfound">
            <div class="notfound-404">
                <h1>404</h1>
            </div>
            <h2>Oops! Página não encontrada</h2>
            <p>A página que você está procurando pode ter sido removida, mudou de nome ou está temporariamente indisponível.</p>
            <a href="{$basePath}">Voltar para o inicio</a>
        </div>
    </div>
</div>