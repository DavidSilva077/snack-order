Frontend - Next.js 14 + React + TypeScript

Interface web para gerenciar produtos e pedidos da lanchonete.\
Desenvolvido com Next.js (App Router), Tailwind CSS, React Query e Axios.

* * * * *

Requisitos:

-   Node.js 18+

-   npm ou pnpm

* * * * *

Configuração:

1.  Instalar dependências:\
    `npm install`

2.  Criar `.env.local` na pasta `/frontend` com o conteúdo:\
    `NEXT_PUBLIC_API_BASE_URL=http://localhost/api`

3.  Rodar em modo desenvolvimento:\
    `npm run dev`

A aplicação ficará disponível em:\
`http://localhost:3000`

Funcionalidades:

-   `/products` → Listagem de produtos + adicionar/excluir

-   `/orders/new` → Criar pedido selecionando produtos

-   `/orders/[id]` → Detalhes do pedido (cliente, itens e status em tempo real)

Atualização de status:\
O frontend faz polling a cada 3 segundos no endpoint do pedido.\
Assim, quando o backend muda o status (fila), a tela é atualizada automaticamente.