<?php

namespace App\Component\Validator;

use App\Component\Exception\ValidatorException;
use App\Dto\ControllerRequest\ProductRequest;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProductDtoValidator
{
    /**
     * @param ProductRequest $request
     * @return void
     * @throws ValidatorException
     */
    public static function validateProductRequest(ProductRequest $request): void
    {
        $messageError = [];

        if (null === $request->price) {
            $messageError[] = 'цена товара';
        }

        if (null === $request->title) {
            $messageError[] = 'название товара';
        }

        if (null === $request->url) {
            $messageError[] = 'ссылка для скачивания';
        }

        if (count($messageError) > 0) {
            throw new ValidatorException(
                message: 'Отсутствуют обязательные значения: ' . implode('; ', $messageError),
                code: ResponseAlias::HTTP_BAD_REQUEST,
                responseCode: 'VALIDATE_PRODUCT_REQUEST',
                logLevel: LogLevel::WARNING
            );
        }
    }
}
