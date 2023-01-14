<?php

namespace App\Component\Utils;

class Aliases
{
    public const TYPE_JWT_ENCODE = 'RS256';
    public const METHOD_POST = 'POST';
    public const METHOD_GET = 'GET';
    public const METHOD_PUT = 'PUT';
    public const METHOD_DELETE = 'DELETE';

    /** Формат даты */
    public const D_FORMAT = 'd.m.Y';

    /** Формат даты и времени */
    public const DT_FORMAT = 'd.m.Y H:i:s';

    public const ORDER_STATUSES = [
        'new' => [
            'value' => 'Новый заказ',
            'description' => 'Новый заказ',
            'code' => 'new',
        ],
        'in_work' => [
            'value' => 'В работе',
            'description' => 'Собирается заказ',
            'code' => 'in_work',
        ],
        'completed' => [
            'value' => 'Завершен',
            'description' => 'Завершенный заказ',
            'code' => 'completed',
        ]
    ];
}
