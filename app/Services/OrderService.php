<?php

namespace App\Services;

use App\Repositories\OrderRepository;

class OrderService extends BaseService
{
    public function __construct(OrderRepository $orderRepository)
    {
        $this->repo = $orderRepository;
    }
}