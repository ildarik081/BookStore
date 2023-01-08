<?php

namespace App\Controller;

use App\Dto\ControllerRequest\BaseDtoRequest;
use App\Dto\ControllerResponse\BaseDtoResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

#[Route('/api/order', name: 'api_order_')]
class OrderController extends AbstractController
{
    /**
     * Оформить заказ
     *
     * @OA\RequestBody(
     *    description="",
     *    @Model(type=BaseDtoRequest::class)
     * )
     * @OA\Response(
     *      response=200,
     *      description="",
     *      @Model(type=BaseDtoResponse::class)
     * )
     * @OA\Tag(name="Order")
     * @param BaseDtoRequest $request
     * @return BaseDtoResponse
     */
    #[Route('/checkout', name: 'checkout', methods: ['POST'])]
    public function checkout(BaseDtoRequest $request): BaseDtoResponse
    {
        return new BaseDtoResponse();
    }

    /**
     * Список заказов
     *
     * @OA\RequestBody(
     *    description="",
     *    @Model(type=BaseDtoRequest::class)
     * )
     * @OA\Response(
     *      response=200,
     *      description="",
     *      @Model(type=BaseDtoResponse::class)
     * )
     * @OA\Tag(name="Order")
     * @param BaseDtoRequest $request
     * @return BaseDtoResponse
     */
    #[Route('/list', name: 'list', methods: ['GET'])]
    public function list(BaseDtoRequest $request): BaseDtoResponse
    {
        return new BaseDtoResponse();
    }
}
