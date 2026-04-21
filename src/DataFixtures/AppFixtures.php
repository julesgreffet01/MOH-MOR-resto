<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Enum\ProductState;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $products = [
            ['Coca-Cola', 3, ProductState::BOISSON],
            ['Fanta', 3, ProductState::BOISSON],
            ['Eau', 2, ProductState::BOISSON],

            ['Burger Classique', 10, ProductState::BURGER],
            ['Cheeseburger', 11, ProductState::BURGER],
            ['Double Bacon', 13, ProductState::BURGER],

            ['Frites', 4, ProductState::ACCOMPAGNEMENT],
            ['Potatoes', 5, ProductState::ACCOMPAGNEMENT],
            ['Onion Rings', 6, ProductState::ACCOMPAGNEMENT],
        ];

        foreach ($products as [$name, $price, $type]) {
            $product = new Product();
            $product->setName($name);
            $product->setPrice($price);
            $product->setType($type);

            $manager->persist($product);
        }

        $manager->flush();
    }
}
