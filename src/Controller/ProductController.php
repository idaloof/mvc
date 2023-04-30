<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/product/create', name: 'product_create')]
    public function createProduct(
        ManagerRegistry $doctrine
    ): Response {
        $entityManager = $doctrine->getManager();

        $product = new Product();
        $product->setName('Keyboard_num_' . rand(1, 9));
        $product->setValue(rand(100, 999));

        // tell Doctrine you want to (eventually) save the product
        // (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$product->getId());
    }

    #[Route('/product/show', name: 'product_show_all')]
    public function showAllProduct(
        ProductRepository $productRepository
    ): Response {
        $products = $productRepository->findAll();

        return $this->json($products);
    }

    #[Route('/product/show/{anId}', name: 'product_by_id')]
    public function showProductById(
        ProductRepository $productRepository,
        int $anId
    ): Response {
        $product = $productRepository->find($anId);

        return $this->json($product);
    }

    #[Route('/product/delete/{anId}', name: 'delete_product_by_id')]
    public function deleteProductById(
        ManagerRegistry $doctrine,
        int $anId
    ): Response {
        $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(Product::class)->find($anId);

        if(!$product) {
            throw $this->createNotFoundException(
                'No product found for id '. $anId
            );
        }

        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute('product_show_all');
    }

    #[Route('/product/update/{anId}/{value}', name: 'product_update')]
    public function updateProduct(
        ManagerRegistry $doctrine,
        int $anId,
        int $value
    ): Response {
        $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(Product::class)->find($anId);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '. $anId
            );
        }

        $product->setValue($value);
        $entityManager->flush();

        return $this->redirectToRoute('product_show_all');
    }

    #[Route('/product/find', name: 'product_find')]
    public function findProductLessThanId(
        ProductRepository $productRepository
    ): Response {
        $aValue = 5000;

        $products = $productRepository->findAllLessThanId($aValue);

        return $this->json($products);
    }
}
