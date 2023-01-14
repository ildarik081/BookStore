<?php

namespace App\Dto\ControllerRequest;

use App\Component\Interface\AbstractDtoControllerRequest;
use JMS\Serializer\Annotation;

class ProductListRequest extends AbstractDtoControllerRequest
{
    /**
     * Сортировка (DESC по умолчанию)
     *
     * - ASC — по возрастанию, от меньших значений к большим
     * - DESC — по убыванию, от больших значений к меньшим
     *
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("orderBy")
     */
    public string $orderBy = 'DESC';

    /**
     * Лимит
     *
     * @var int|null
     * @Annotation\Type("integer")
     * @Annotation\SerializedName("limit")
     */
    public ?int $limit = null;

    /**
     * Смещение
     *
     * @var int|null
     * @Annotation\Type("integer")
     * @Annotation\SerializedName("offset")
     */
    public ?int $offset = null;
}
