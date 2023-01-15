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

    /** Наименование свойства при загрузке изображения */
    public const UPLOAD_PROPERTY_NAME_IMAGE = 'image';

    /** Ограничение на размер загружаемого файла (2МБ) */
    public const FILE_SIZE = 2 * 1024 * 1024;

    /** Допустимые расширения файлов */
    public const TYPE_FILE = ['jpg', 'jpeg', 'webp'];

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
