## Iniciando o projeto

```
    git clone https://gitlab.com/gazetamarista/rkadvisors.com.br
    cd rkadvisors.com.br
```

## Iniciando o front

```
    cd rkadvisors.com.br

    // Instalar dependencias
    npm install

    // Compilar para desenvolvimento
    npm run dev 

    // Compilar para produção
    npm run prod
```

## Iniciando a aplicação com docker

Compile a imagem e inicie o container

```
    docker-compose up -d
```

## Importante 🚨

Caso for rodar o projeto com **apache**, trocar no arquivo **.htaccess**:

```

    // Atual
    RewriteBase /

    // Ajustar
    RewriteBase /rkadvisors.com.br

```

Alterar no **application/configs/application.ini**:

```
    // Atual
    gazetamarista.config.basepath = "/rkadvisors.com.br"

    // Ajustar
    gazetamarista.config.basepath = ""
```