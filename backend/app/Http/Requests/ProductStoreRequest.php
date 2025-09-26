<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
  public function rules(): array {
    return [
      'nome' => ['required','string','max:255'],
      'preco' => ['required','numeric','min:0'],
      'categoria' => ['required','string','max:255'],
    ];
  }
}
