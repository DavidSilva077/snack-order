# 🍔 SnackOrder - Sistema de Gerenciamento de Pedidos

Este projeto consiste em um sistema simples para gerenciamento de pedidos de uma lanchonete.

## 📌 Visão Geral

O sistema é composto por:

- **Backend** → API REST em **Laravel 10+** usando **PostgreSQL** e **Queues** para processar pedidos.
- **Frontend** → Aplicação em **Next.js 14 + React + TypeScript**, com **TailwindCSS** e **React Query** para comunicação em tempo real (polling).

## ✨ Funcionalidades

- **Produtos**
 - CRUD completo de produtos
- **Pedidos**
 - Criação de pedidos com múltiplos produtos
 - Atualização automática do status (`pendente` → `em_preparacao`)
 - Detalhes do pedido com polling para status em tempo real

## 📽 Demonstração

[🎥 Assista ao vídeo de demonstração da aplicação](COLOQUE_AQUI_O_LINK_DO_VIDEO)

 ## 🚀 Como Rodar

- Siga as instruções em [`backend/README.md`](backend/README.md) para subir o backend.
- Depois, siga [`frontend/README.md`](frontend/README.md) para rodar o frontend.`