'use client'
import { useParams } from 'next/navigation'
import { useOrder } from '@/hooks/useOrders'
import StatusBadge from '@/components/StatusBadge'

export default function OrderDetailsPage() {
  const params = useParams<{ id: string }>()
  const id = Number(params.id)
  const { data: order, isLoading, isError, refetch } = useOrder(id, 3000)

  if (isLoading) return <div className="animate-pulse">Carregando detalhes…</div>
  if (isError || !order) return (
    <div className="rounded border border-red-300 bg-red-50 p-3">
      <p className="text-sm text-red-700">Erro ao carregar pedido.</p>
      <button onClick={()=>refetch()} className="mt-2 rounded border px-2 py-1">Tentar novamente</button>
    </div>
  )

  return (
    <div className="space-y-4">
      <div className="flex flex-wrap items-end justify-between gap-3">
        <div>
          <h2 className="text-2xl font-semibold">Pedido #{order.id}</h2>
          <p className="text-sm text-gray-600">
            Cliente: <b>{order.cliente}</b> · Data: {new Date(order.data).toLocaleString('pt-BR')}
          </p>
        </div>
      </div>

      {/* barra sticky de status para quando o polling atualizar */}
      <div className="sticky top-0 z-10 flex items-center justify-between border-b bg-white px-1 py-2">
        <span>Status:</span>
        <StatusBadge status={order.status} />
      </div>

      <div className="overflow-hidden rounded border">
        <table className="w-full">
          <thead className="bg-gray-50 text-left text-sm">
            <tr>
              <th className="p-3">Produto</th>
              <th className="p-3 w-24 text-right">Qtd</th>
            </tr>
          </thead>
          <tbody>
            {order.itens.map((i, idx) => (
              <tr key={idx} className="border-t">
                <td className="p-3">{i.product?.nome ?? i.product_id}</td>
                <td className="p-3 text-right">{i.quantidade}</td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  )
}
