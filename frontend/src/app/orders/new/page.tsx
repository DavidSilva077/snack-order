'use client'
import { useState } from 'react'
import { useProducts } from '@/hooks/useProducts'
import { useCreateOrder } from '@/hooks/useOrders'
import { useRouter } from 'next/navigation'

export default function NewOrderPage() {
  const { data: products = [], isLoading } = useProducts()
  const createOrder = useCreateOrder()
  const router = useRouter()

  const [cliente, setCliente] = useState('')
  const [itens, setItens] = useState<{ product_id: number; quantidade: number }[]>([])

  const addItem = (product_id: number) => {
    setItens((prev) => {
      const found = prev.find(i => i.product_id === product_id)
      if (found) return prev.map(i => i.product_id === product_id ? { ...i, quantidade: i.quantidade + 1 } : i)
      return [...prev, { product_id, quantidade: 1 }]
    })
  }
  const changeQty = (product_id: number, delta: number) => {
    setItens(prev => prev
      .map(i => i.product_id === product_id ? { ...i, quantidade: Math.max(1, i.quantidade + delta) } : i)
      .filter(i => i.quantidade > 0)
    )
  }

  const total = itens.reduce((acc, i) => {
    const p = products.find(p => p.id === i.product_id)
    if (!p) return acc
    return acc + Number(p.preco) * i.quantidade
  }, 0)

  const canCreate = cliente.trim().length > 0 && itens.length > 0

  const submit = async () => {
    const res = await createOrder.mutateAsync({ cliente, itens })
    router.push(`/orders/${res.id}`)
  }

  return (
    <div className="grid grid-cols-1 md:grid-cols-[1fr_360px] gap-6">
      <section>
        <h2 className="text-2xl font-semibold mb-4">Novo Pedido</h2>
        <label className="block mb-4">
          <span className="text-sm">Cliente</span>
          <input className="mt-1 w-full rounded border px-3 py-2" value={cliente} onChange={(e)=>setCliente(e.target.value)} />
        </label>

        <h3 className="text-lg font-medium mb-2">Catálogo de Produtos</h3>
        {isLoading ? (
          <div className="animate-pulse">Carregando…</div>
        ) : (
          <div className="grid grid-cols-[repeat(auto-fit,minmax(160px,1fr))] gap-3">
            {products.map(p => (
              <button key={p.id} onClick={()=>addItem(p.id)} className="border rounded p-3 text-left hover:bg-gray-50">
                <div className="font-medium">{p.nome}</div>
                <div className="text-sm text-gray-500">{p.categoria}</div>
                <div className="text-sm">
                  {Number(p.preco).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}
                </div>
              </button>
            ))}
          </div>
        )}
      </section>

      <aside>
        <h3 className="text-lg font-semibold mb-3">Resumo do Pedido</h3>
        {itens.length === 0 ? (
          <div className="rounded border-2 border-dashed p-8 text-center text-sm text-gray-600">
            Nenhum item selecionado.
          </div>
        ) : (
          <div className="space-y-2">
            {itens.map(i => {
              const p = products.find(p => p.id === i.product_id)!
              return (
                <div key={i.product_id} className="flex items-center justify-between rounded bg-gray-50 p-2">
                  <div>
                    <div className="font-medium">{p?.nome}</div>
                    <div className="text-xs text-gray-500">
                      {Number(p.preco).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}
                    </div>
                  </div>
                  <div className="flex items-center gap-2">
                    <button className="h-7 w-7 rounded-full bg-gray-200" onClick={()=>changeQty(i.product_id, -1)}>-</button>
                    <span className="w-6 text-center">{i.quantidade}</span>
                    <button className="h-7 w-7 rounded-full bg-gray-200" onClick={()=>changeQty(i.product_id, +1)}>+</button>
                  </div>
                </div>
              )
            })}
          </div>
        )}

        <div className="mt-4 border-t pt-3 text-sm">
          <div className="flex justify-between">
            <span>Total</span>
            <span className="font-medium">
              {total.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}
            </span>
          </div>
        </div>

        <button
          className={`mt-3 w-full rounded px-4 py-2 text-white ${canCreate ? 'bg-blue-600' : 'bg-gray-400 cursor-not-allowed'}`}
          disabled={!canCreate}
          onClick={submit}
        >
          Criar pedido
        </button>
      </aside>
    </div>
  )
}
