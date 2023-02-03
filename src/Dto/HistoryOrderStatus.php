<?php

namespace App\Dto;

use JMS\Serializer\Annotation;

class HistoryOrderStatus
{
    /**
     * Идентификатор в истории изменения статусов
     *
     * @var int|null
     * @Annotation\Type("integer")
     * @Annotation\SerializedName("id")
     */
    public ?int $id = null;

    /**
     * Дата изменения статуса заказа
     *
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("dtCreate")
     */
    public string $dtCreate;

    /**
     * Статус
     *
     * @var string|null
     * @Annotation\Type("string")
     * @Annotation\SerializedName("value")
     */
    public ?string $value = null;

    /**
     * Описание к статусу
     *
     * @var string|null
     * @Annotation\Type("string")
     * @Annotation\SerializedName("description")
     */
    public ?string $description = null;
}
