<?php

namespace App\Controller;

use App\Enum\ProductState;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    public function __construct(private readonly ProductRepository $productRepository)
    {
    }

    #[Route('/products', name: 'products', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $boissons = $this->productRepository->findByState(ProductState::BOISSON);
        $burgers = $this->productRepository->findByState(ProductState::BURGER);
        $accompagnements = $this->productRepository->findByState(ProductState::ACCOMPAGNEMENT);

        function formatProducts(array $items): array
        {
            return array_map(function ($product) {
                return [
                    'id' => $product->getId(),
                    'name' => $product->getName(),
                    'price' => $product->getPrice(),
                    'type' => $product->getType()->value,
                ];
            }, $items);
        }

        return $this->json([
            'products' => [
                'boissons' => formatProducts($boissons),
                'burgers' => formatProducts($burgers),
                'accompagnements' => formatProducts($accompagnements),
            ],
        ]);
    }
}
