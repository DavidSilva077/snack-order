export const qk = {
  products: ['products'] as const,
  product: (id: number) => ['product', id] as const,
  order: (id: number) => ['order', id] as const,
}
