<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStatusUpdateRequest;
use App\Http\Requests\OrderStoreRequest;
use App\Jobs\AdvanceOrderStatusJob;
use App\Models\Order;
use App\Services\OrderService;

class OrderController extends Controller
{
  public function __construct(private OrderService $service) {}

  public function store(OrderStoreRequest $request)
  {
    $data = $request->validated();
    $order = $this->service->create($data['cliente'], $data['itens']);

    AdvanceOrderStatusJob::dispatch($order->id)->delay(now()->addSeconds(5));

    return response()->json($order->fresh(['itens.product']), 201);
  }

  public function show(Order $order)
  {
    return $order->load(['itens.product']);
  }

  public function updateStatus(OrderStatusUpdateRequest $request, Order $order)
  {
    $order->update(['status' => $request->validated()['status']]);
    return $order->fresh(['itens.product']);
  }
}
