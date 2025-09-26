import React from 'react'
import { OrderStatus } from '@/lib/types'

const MAP: Record<OrderStatus, { label: string; dot: string }> = {
  pendente: { label: 'Pendente', dot: 'bg-yellow-500' },
  em_preparacao: { label: 'Em preparação', dot: 'bg-blue-500' },
  pronto: { label: 'Pronto', dot: 'bg-green-600' },
  entregue: { label: 'Entregue', dot: 'bg-gray-600' },
  cancelado: { label: 'Cancelado', dot: 'bg-red-600' },
}

export default function StatusBadge({ status }: { status: OrderStatus }) {
  const s = MAP[status] ?? { label: status, dot: 'bg-gray-400' }
  return (
    <span className="inline-flex items-center gap-2 rounded border px-2 py-1 text-sm">
      <span className={`inline-block size-2 rounded-full ${s.dot}`} />
      {s.label}
    </span>
  )
}
