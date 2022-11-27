<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'product_')]
class ProductController extends AbstractController
{
    #[Route('/product/list', name: 'list')]
    public function list(): Response
    {
        return $this->render('product/product.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/product/item/{id}', name: 'item')]
    public function item(int $id): Response
    {
        return $this->render('product/item.html.twig', [
            'title' => 'Книга №' . $id,
            'itemTitle' => 'Книга ' . $id,
        ]);
    }
}
