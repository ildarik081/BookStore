<?php

namespace App\Component\Utils;

use App\Component\Exception\UtilsException;
use App\Component\Interfaces\ProductInterface;
use Doctrine\Common\Collections\Collection;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProductUtils
{
    /**
     * Посчитать общую стоимость товаров
     *
     * @param ProductInterface[] $products
     * @return float
     */
    public static function calculationTotalPrice(Collection $products): float
    {
        $totalPrice = 0.0;

        foreach ($products as $product) {
            $totalPrice += $product->getProduct()->getPrice() * $product->getQuantity();
        }

        return $totalPrice;
    }

    /**
     * Посчитать количество товаров
     *
     * @param ProductInterface[] $products
     * @return integer
     */
    public static function calculationTotalQuantity(Collection $products): int
    {
        $totalQuantity = 0;

        foreach ($products as $product) {
            $totalQuantity += $product->getQuantity();
        }

        return $totalQuantity;
    }
}
