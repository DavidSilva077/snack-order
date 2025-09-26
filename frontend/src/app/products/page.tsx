'use client'
import { useState } from 'react'
import { useProducts, useCreateProduct, useDeleteProduct } from '@/hooks/useProducts'
import AddProductModal from '@/components/AddProductModal'

export default function ProductsPage() {
  const [search, setSearch] = useState('')
  const [open, setOpen] = useState(false)
  const { data: products = [], isLoading } = useProducts(search)
  const create = useCreateProduct()
  const del = useDeleteProduct()

  return (
    <div className="space-y-4">
      <div className="flex items-center justify-between">
        <h2 className="text-2xl font-semibold">Produtos</h2>
        <button onClick={()=>setOpen(true)} className="rounded border px-3 py-2 hover:bg-gray-50">Adicionar</button>
      </div>

      <div>
        <label className="block">
          <span className="text-sm">Buscar</span>
          <input
            placeholder="Digite para filtrar"
            className="mt-1 w-full rounded border px-3 py-2"
            value={search}
            onChange={(e)=>setSearch(e.target.value)}
          />
        </label>
      </div>

      {isLoading ? (
        <div className="animate-pulse">Carregando…</div>
      ) : (
        <div className="overflow-hidden rounded border">
          <table className="w-full">
            <thead className="bg-gray-50 text-left text-sm">
              <tr>
                <th className="p-3">Nome</th>
                <th className="p-3">Categoria</th>
                <th className="p-3 text-right">Preço</th>
                <th className="p-3 w-32"></th>
              </tr>
            </thead>
            <tbody>
              {products.map((p) => (
                <tr key={p.id} className="border-t">
                  <td className="p-3">{p.nome}</td>
                  <td className="p-3 text-gray-600">{p.categoria}</td>
                  <td className="p-3 text-right">
                    {Number(p.preco).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}
                  </td>
                  <td className="p-3 text-right">
                    <button onClick={()=>del.mutate(p.id)} className="text-red-600 hover:underline">
                      Excluir
                    </button>
                  </td>
                </tr>
              ))}

              {products.length === 0 && (
                <tr><td colSpan={4} className="p-6 text-center text-gray-500">Nenhum produto encontrado</td></tr>
              )}
            </tbody>
          </table>
        </div>
      )}

      <AddProductModal
        open={open}
        onClose={()=>setOpen(false)}
        onSubmit={async (data)=>{ await create.mutateAsync(data) }}
      />
      <div aria-live="polite" className="sr-only">
        {create.isSuccess ? 'Produto criado com sucesso' : ''}
      </div>
    </div>
  )
}
