
'use client'
import { Inter } from 'next/font/google'
import './globals.css'
import { QueryClient, QueryClientProvider } from '@tanstack/react-query'

const inter = Inter({ subsets: ['latin'] })
const queryClient = new QueryClient()

export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html lang="pt-BR">
      <body className={inter.className}>
        <QueryClientProvider client={queryClient}>
          <header className="flex items-center justify-between border-b px-6 py-3">
            <h1 className="font-semibold">SnackOrder</h1>
            <nav className="flex gap-4 text-sm">
              <a href="/products" className="hover:underline">Produtos</a>
              <a href="/orders/new" className="hover:underline">Novo Pedido</a>
            </nav>
          </header>
          <main className="max-w-5xl mx-auto p-6">{children}</main>
        </QueryClientProvider>
      </body>
    </html>
  )
}
