<?php

namespace App\Component\Utils;

use App\Component\Exception\UtilsException;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class Utils
{
    /**
     * Конвертация CSV файлв в массив
     *
     * @param string $csvFilePath
     * @return array
     * @throws UtilsException
     */
    public static function convertCsvToArray(string $csvFilePath): array
    {
        if (!file_exists($csvFilePath)) {
            throw new UtilsException(
                message: 'Файл не найден: ' . $csvFilePath,
                code: ResponseAlias::HTTP_BAD_REQUEST,
                responseCode: 'UTILS_FILE_NOT_FOUND',
                logLevel: LogLevel::CRITICAL
            );
        }

        $dataFile = fopen($csvFilePath, 'r');

        if (false === $dataFile) {
            throw new UtilsException(
                message: 'Ошибка при открытии файла ' . $csvFilePath,
                code: ResponseAlias::HTTP_BAD_REQUEST,
                responseCode: 'UTILS_FILE_ERROR',
                logLevel: LogLevel::CRITICAL
            );
        }

        $dataCSV = [];
        $handle = fgetcsv($dataFile, 0, ';');

        while ($handle !== false) {
            $dataCSV[] = $handle;
        }

        fclose($dataFile);

        return $dataCSV;
    }
}
