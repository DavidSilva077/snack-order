<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
  public function rules(): array {
    return [
      'nome' => ['sometimes','string','max:255'],
      'preco' => ['sometimes','numeric','min:0'],
      'categoria' => ['sometimes','string','max:255'],
    ];
  }
}
