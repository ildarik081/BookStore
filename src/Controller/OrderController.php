<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'order_')]
class OrderController extends AbstractController
{
    #[Route('/order/checkout', name: 'checkout')]
    public function checkout(): Response
    {
        return $this->render('order/order.html.twig', [
            'controller_name' => 'OrderController',
        ]);
    }

    #[Route('/order/list', name: 'list')]
    public function list(): Response
    {
        return $this->render('order/order.html.twig', [
            'controller_name' => 'OrderController',
        ]);
    }
}
