<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
{
  public function rules(): array {
    return [
      'cliente' => ['required','string','max:255'],
      'itens' => ['required','array','min:1'],
      'itens.*.product_id' => ['required','integer','exists:products,id'],
      'itens.*.quantidade' => ['required','integer','min:1'],
    ];
  }
}
