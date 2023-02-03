<?php

namespace App\Controller;

use App\Component\Exception\ControllerException;
use App\Component\Utils\Aliases;
use App\Dto\ControllerRequest\BaseRequest;
use App\Dto\ControllerRequest\CheckoutRequest;
use App\Dto\ControllerResponse\AcquiringResponse;
use App\Dto\ControllerResponse\BaseResponse;
use App\Dto\ControllerResponse\OrderListResponse;
use App\Dto\ControllerResponse\SuccessResponse;
use App\Entity\Order;
use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

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
        if (
            !in_array(
                $request->paymentType,
                [
                    Aliases::PAYMENT_TYPE['card']['code'],
                    Aliases::PAYMENT_TYPE['sbp']['code']
                ],
                true
            )
        ) {
            throw new ControllerException(
                message: 'Не известный тип оплаты',
                code: ResponseAlias::HTTP_BAD_REQUEST,
                responseCode: 'PAYMENT_TYPE_NOT_FOUND',
                logLevel: LogLevel::WARNING
            );
        }

        return $this->orderService->checkout($request);
    }

    /**
     * Создать транзакцию
     *
     * Получить ссылку для оплаты заказа
     *
     * @OA\Response(
     *      response=200,
     *      description="Ссылка на оплату заказа",
     *      @Model(type=AcquiringResponse::class)
     * )
     * @OA\Tag(name="Order")
     * @param Order $order
     * @return AcquiringResponse
     */
    #[Route('/create-transaction/{id}', name: 'create_transaction', methods: ['GET'])]
    public function createTransaction(Order $order): AcquiringResponse
    {
        return $this->orderService->createTransaction($order);
    }

    /**
     * Список заказов
     *
     * @OA\Response(
     *      response=200,
     *      description="Список заказов",
     *      @Model(type=OrderListResponse::class)
     * )
     * @OA\Tag(name="Order")
     * @param BaseRequest $request
     * @return OrderListResponse
     */
    #[Route('/list', name: 'order_list', methods: ['GET'])]
    public function getOrderList(BaseRequest $request): OrderListResponse
    {
        return $this->orderService->getOrderList($request);
    }
}
