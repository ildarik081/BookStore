<?php

namespace App\Controller;

use App\Dto\ControllerRequest\BaseDtoRequest;
use App\Dto\ControllerResponse\BaseResponse;
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
     *      @Model(type=BaseResponse::class)
     * )
     * @OA\Tag(name="Order")
     * @param BaseDtoRequest $request
     * @return BaseResponse
     */
    #[Route('/checkout', name: 'checkout', methods: ['POST'])]
    public function checkout(BaseDtoRequest $request): BaseResponse
    {
        return new BaseResponse();
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
     *      @Model(type=BaseResponse::class)
     * )
     * @OA\Tag(name="Order")
     * @param BaseDtoRequest $request
     * @return BaseResponse
     */
    #[Route('/list', name: 'list', methods: ['GET'])]
    public function list(BaseDtoRequest $request): BaseResponse
    {
        return new BaseResponse();
    }
}
