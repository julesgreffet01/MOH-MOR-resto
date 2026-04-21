<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class OrderController extends AbstractController
{

    public function __construct(private readonly OrderRepository $orderRepository, private readonly ProductRepository $productRepository)
    {

    }
    #[Route('/order', name: 'order_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $productsIds = $data['products'] ?? null;

        if (!is_array($productsIds) || count($productsIds) === 0) {
            return $this->json([
                'success' => false,
                'message' => 'Products must be a non-empty array'
            ], 400);
        }

        $products = $this->productRepository->findBy([
            'id' => $productsIds
        ]);

        if (count($products) !== count($productsIds)) {
            return $this->json([
                'success' => false,
                'message' => 'One or more products not found'
            ], 400);
        }

        $order = new Order();
        $price = 0;
        $order->setIsFinish(false);
        $order->setIsPayed(false);

        foreach ($products as $product) {
            $price += $product->getPrice();
            $order->addProduct($product);
        }

        $this->orderRepository->save($order);
        return $this->json([
            'success' => true,
            'message' => 'Order created',
            'data' => [
                'id' => $order->getUuid(),
                'price' => $price
            ]
        ]);
    }
}
