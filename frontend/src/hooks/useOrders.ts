import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query'
import { api } from '@/lib/api'
import { Order } from '@/lib/types'
import { qk } from '@/lib/queryKeys'

export function useCreateOrder() {
  return useMutation({
    mutationFn: async (payload: { cliente: string; itens: { product_id: number; quantidade: number }[] }) =>
      (await api.post<Order>('/orders', payload)).data,
  })
}

export function useOrder(id: number, refetchMs?: number) {
  return useQuery({
    queryKey: qk.order(id),
    queryFn: async () => (await api.get<Order>(`/orders/${id}`)).data,
    refetchInterval: refetchMs,
  })
}

export function useUpdateOrderStatus() {
  const qc = useQueryClient()
  return useMutation({
    mutationFn: async (p: { id: number; status: string }) =>
      (await api.patch<Order>(`/orders/${p.id}/status`, { status: p.status })).data,
    onSuccess: (_, p) => qc.invalidateQueries({ queryKey: qk.order(p.id) }),
  })
}
