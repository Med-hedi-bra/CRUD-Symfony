<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        for ($i = 0; $i < 50; $i++) {
            $product = new Product();
            $product->setName("name $i");
            $product->setPrice($i*2.5);
            $product->setDescription("description $i");
            $manager->persist($product);
        }

        $manager->flush();
    }
}
