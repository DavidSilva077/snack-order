**Backend - API (Laravel 10 + Sail + PostgreSQL)**

API REST para gerenciamento de produtos e pedidos de uma lanchonete.

Desenvolvido em Laravel 10 com PostgreSQL e uso de filas (queues) para processamento assíncrono.

* * * * *

**Requisitos**

-   Docker + Docker Compose

-   PHP 8.2 ou superior (necessário apenas se for rodar fora do Sail)

* * * * *

**Configuração**

1.  Copiar o arquivo `.env.example` para `.env`:

    `cp .env.example .env`

2.  Ajustar as variáveis de ambiente, se necessário:

    ```
    DB_CONNECTION=pgsql
    DB_HOST=pgsql
    DB_PORT=5432
    DB_DATABASE=laravel
    DB_USERNAME=sail
    DB_PASSWORD=password
    QUEUE_CONNECTION=redis

3.  Executar com Sail (Docker):

    -   Subir os containers:

        `./vendor/bin/sail up -d`
        
    -   Gerar a chave da aplicação:
  
        `./vendor/bin/sail artisan key:generate`

    -   Rodar as migrations:

        `./vendor/bin/sail artisan migrate`
        
    -   Rodar os seeders (para popular o banco com dados iniciais):

        `./vendor/bin/sail artisan db:seed`

    -   Rodar a fila para processar os jobs:

        `./vendor/bin/sail artisan queue:work`

A API estará disponível em:\
<http://localhost/api>

* * * * *

**Endpoints principais**

**Produtos:**

-   GET /api/products

-   POST /api/products

-   PUT /api/products/{id}

-   DELETE /api/products/{id}

**Pedidos:**

-   POST /api/orders

-   GET /api/orders/{id}

-   PATCH /api/orders/{id}/status

* * * * *

**Fluxo da fila**

Ao criar um pedido (POST /api/orders), ele entra na fila.\
Após 5 segundos, o status muda automaticamente de "pendente" para "em_preparacao".
