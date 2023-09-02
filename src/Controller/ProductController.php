<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends AbstractController
{
    private $productRepo;
    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepo = $productRepo;
    }
    #[Route('/dev/product', name: 'get_all', methods: ["GET"])]
    public function getAll(): JsonResponse
    {
        $products = $this->productRepo->findAll();
        foreach ($products as $prod) {
            $data[] = [
                'id' => $prod->getId(),
                'Name' => $prod->getName(),
                'Description' => $prod->getDescription(),
                'Price' => $prod->getPrice()
            ];
        }


        return new JsonResponse($data, Response::HTTP_OK);
    }
    #[Route('/dev/product/{id}', name: 'get_by_id', methods: ["GET"])]
    public function get($id): JsonResponse
    {
        $data = [];
        $product = $this->productRepo->findOneBy(['id' => $id]);
        if($product != null){
            $data = [
                'id' => $product->getId(),
                'Name' => $product->getName(),
                'Description' => $product->getDescription(),
                'Price' => $product->getPrice()
            ];
        }
       

        return new JsonResponse($data, Response::HTTP_OK);
    }
    #[Route('/dev/product', name: 'app_product', methods: ["POST"])]
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $name = $data['name'];
        $description = $data['description'];
        // $price = floatval($data['price']);


        if (empty($name) || empty($description)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $this->productRepo->saveProduct($name, $description, 23.4);

        return new JsonResponse(['status' => 'Product created!'], Response::HTTP_CREATED);
    }

    #[Route('/dev/product/{id}', name: 'update', methods: ["PUT"])]
    public function update($id, Request $request): JsonResponse
    {
        $product = $this->productRepo->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['name']) ? true : $product->setName($data['name']);
        empty($data['description']) ? true : $product->setDescription($data['description']);
        empty($data['price']) ? true : $product->setPrice($data['price']);


        $updatedProduct = $this->productRepo->updateProduct($product);

        return new JsonResponse($updatedProduct->toArray(), Response::HTTP_OK);
    }

    #[Route('/dev/product/{id}', name: 'delete', methods: ["DELETE"])]

public function delete($id): JsonResponse
{
    $product = $this->productRepo->findOneBy(['id' => $id]);

    $this->productRepo->removeProduct($product);

    return new JsonResponse(['status' => 'pr$product deleted'], Response::HTTP_NO_CONTENT);
}
}
