<?php

namespace App\Dto\ControllerResponse;

use App\Component\Interface\Controller\ControllerResponseInterface;
use App\Dto\FullOrder;
use JMS\Serializer\Annotation;

class OrderListResponse implements ControllerResponseInterface
{
    /**
     * Список заказов
     *
     * @var FullOrder[]
     * @Annotation\Type("array<App\Dto\FullOrder>")
     * @Annotation\SerializedName("list")
     */
    public array $list = [];
}
