<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
      
    }

    public function saveProduct($name, $description, $price)
    {
        $entityManager  = $this->getEntityManager();
        $newProduct = new Product();

        $newProduct
            ->setName($name)
            ->setDescription($description)
            ->setPrice($price);

        $entityManager->persist($newProduct);
        $entityManager->flush();
    }

    public function updateProduct(Product $product):Product{
        $entityManager = $this->getEntityManager();
        $entityManager->persist($product);
        $entityManager->flush();
        return $product;
    }

    public function removeProduct(Product $product){
        $entityManager = $this->getEntityManager();
        $entityManager->remove($product);
        $entityManager->flush();
      
    }



}
