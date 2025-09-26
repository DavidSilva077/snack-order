'use client'
import * as React from 'react'

type Props = {
  open: boolean
  onClose: () => void
  onSubmit: (data: { nome: string; preco: number; categoria: string }) => Promise<void> | void
}

export default function AddProductModal({ open, onClose, onSubmit }: Props) {
  const [form, setForm] = React.useState({ nome: '', preco: 0, categoria: '' })
  React.useEffect(() => {
    if (open) setTimeout(() => document.getElementById('nome')?.focus(), 0)
  }, [open])
  if (!open) return null
  const canSave = !!form.nome && !!form.categoria && form.preco > 0

  return (
    <div className="fixed inset-0 z-50 grid place-items-center">
      <div className="absolute inset-0 bg-black/30" onClick={onClose} />
      <div role="dialog" aria-modal="true" className="relative w-full max-w-md rounded-lg bg-white p-4 shadow">
        <h3 className="text-lg font-semibold">Novo produto</h3>
        <div className="mt-3 space-y-3">
          <label className="block">
            <span className="text-sm">Nome</span>
            <input id="nome" className="mt-1 w-full rounded border px-3 py-2"
              value={form.nome} onChange={(e)=>setForm({...form, nome:e.target.value})}/>
          </label>
          <label className="block">
            <span className="text-sm">Preço</span>
            <input type="number" step="0.01" className="mt-1 w-full rounded border px-3 py-2"
              value={form.preco} onChange={(e)=>setForm({...form, preco:Number(e.target.value)})}/>
          </label>
          <label className="block">
            <span className="text-sm">Categoria</span>
            <input className="mt-1 w-full rounded border px-3 py-2"
              value={form.categoria} onChange={(e)=>setForm({...form, categoria:e.target.value})}/>
          </label>
        </div>
        <div className="mt-4 flex justify-end gap-2">
          <button onClick={onClose} className="rounded border px-3 py-2">Cancelar</button>
          <button
            onClick={async ()=>{ await onSubmit(form); onClose(); }}
            className={`rounded px-3 py-2 text-white ${canSave ? 'bg-blue-600' : 'bg-gray-400 cursor-not-allowed'}`}
            disabled={!canSave}
          >Salvar</button>
        </div>
      </div>
    </div>
  )
}
