<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
  use HasFactory;

  protected $fillable = ['cliente', 'data', 'status'];
  protected $casts = ['data' => 'datetime'];

  public function itens(): HasMany { return $this->hasMany(OrderItem::class); }

  public function getTotalAttribute() { return $this->itens->sum('subtotal'); }
}
