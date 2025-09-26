<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderStatusUpdateRequest extends FormRequest
{
  public function rules(): array {
    return [
      'status' => ['required','in:pendente,em_preparacao,pronto,entregue,cancelado'],
    ];
  }
}
