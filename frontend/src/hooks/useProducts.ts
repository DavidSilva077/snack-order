import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query'
import { api } from '@/lib/api'
import { Product } from '@/lib/types'
import { qk } from '@/lib/queryKeys'

export function useProducts(search?: string, page?: number) {
  return useQuery({
    queryKey: [...qk.products, { search, page }],
    queryFn: async () => {
      const res = await api.get<Product[]>('/products', { params: { search, page } })
      return res.data
    },
  })
}

export function useCreateProduct() {
  const qc = useQueryClient()
  return useMutation({
    mutationFn: async (data: Omit<Product, 'id'>) => (await api.post<Product>('/products', data)).data,
    onSuccess: () => qc.invalidateQueries({ queryKey: qk.products }),
  })
}

export function useDeleteProduct() {
  const qc = useQueryClient()
  return useMutation({
    mutationFn: async (id: number) => (await api.delete(`/products/${id}`)).data,
    onSuccess: () => qc.invalidateQueries({ queryKey: qk.products }),
  })
}
