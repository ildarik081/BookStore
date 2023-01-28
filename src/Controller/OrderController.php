<?php

namespace App\Controller;

use App\Dto\ControllerRequest\BaseRequest;
use App\Dto\ControllerRequest\CheckoutRequest;
use App\Dto\ControllerResponse\BaseResponse;
use App\Dto\ControllerResponse\SuccessResponse;
use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

#[Route('/api/order', name: 'api_order_')]
class OrderController extends AbstractController
{
    public function __construct(private readonly OrderService $orderService)
    {
    }

    /**
     * Оформить заказ
     *
     * @OA\RequestBody(
     *    description="Данные для оформления заказа",
     *    @Model(type=CheckoutRequest::class)
     * )
     * @OA\Response(
     *      response=200,
     *      description="Статус оформления заказа",
     *      @Model(type=SuccessResponse::class)
     * )
     * @OA\Tag(name="Order")
     * @param CheckoutRequest $request
     * @return SuccessResponse
     */
    #[Route('/checkout', name: 'checkout', methods: ['POST'])]
    public function checkout(CheckoutRequest $request): SuccessResponse
    {
        return $this->orderService->checkout($request);
    }

    /**
     * Список заказов
     *
     * @OA\RequestBody(
     *    description="",
     *    @Model(type=BaseRequest::class)
     * )
     * @OA\Response(
     *      response=200,
     *      description="",
     *      @Model(type=BaseResponse::class)
     * )
     * @OA\Tag(name="Order")
     * @param BaseRequest $request
     * @return BaseResponse
     */
    #[Route('/list', name: 'list', methods: ['GET'])]
    public function list(BaseRequest $request): BaseResponse
    {
        return new BaseResponse();
    }
}
