<?php

namespace App\Component\Validator;

use App\Component\Exception\ValidatorException;
use App\Component\Utils\Aliases;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ImageValidator
{
    /**
     * @param Request $request
     * @return void
     * @throws ValidatorException
     */
    public static function validateImageRequest(Request $request): void
    {
        $image = $request->files->get(Aliases::UPLOAD_PROPERTY_NAME_IMAGE);

        if (null === $image) {
            throw new ValidatorException(
                message: 'Отсутствует изображение',
                code: ResponseAlias::HTTP_BAD_REQUEST,
                responseCode: 'VALIDATE_IMAGE_REQUEST',
                logLevel: LogLevel::WARNING
            );
        }

        $errorMessage = [];

        if ($image->getSize() > Aliases::FILE_SIZE) {
            $errorMessage[] = 'Размер изображения превышает 2 МБ';
        }

        $fileType = explode('/', $image->getMimeType());

        if (!in_array($fileType[1], Aliases::TYPE_FILE)) {
            $errorMessage[] = 'Не доступное расширение файла';
        }

        if (count($errorMessage) > 0) {
            throw new ValidatorException(
                message: 'Ошибки валидации загрузки изображения: ' . join('; ', $errorMessage),
                code: ResponseAlias::HTTP_BAD_REQUEST,
                responseCode: 'VALIDATE_IMAGE_REQUEST',
                logLevel: LogLevel::WARNING
            );
        }
    }
}
