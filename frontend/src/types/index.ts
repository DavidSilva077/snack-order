export type Product = {
    id: number
    nome: string
    preco: number
    categoria: string
    created_at?: string
    updated_at?: string
  }
  
  export type OrderItem = {
    product_id: number
    quantidade: number
    product?: Product
    preco_unitario?: number
    subtotal?: number
  }
  
  export type OrderStatus = 'pendente' | 'em_preparacao' | 'pronto' | 'entregue' | 'cancelado'
  
  export type Order = {
    id: number
    cliente: string
    data: string
    status: OrderStatus
    itens: OrderItem[]
    total?: number
  }
  