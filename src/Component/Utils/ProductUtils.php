<?php

namespace App\Component\Utils;

use App\Component\Interface\ProductInterface;
use Doctrine\Common\Collections\Collection;

class ProductUtils
{
    /**
     * Посчитать общую стоимость товаров
     *
     * @param Collection<int, ProductInterface> $products
     * @return float
     */
    public static function calculationTotalPrice(Collection $products): float
    {
        $totalPrice = 0.0;

        /** @var ProductInterface[] $products */
        foreach ($products as $product) {
            $totalPrice += $product->getProduct()->getPrice() * $product->getQuantity();
        }

        return $totalPrice;
    }

    /**
     * Посчитать количество товаров
     *
     * @param Collection<int, ProductInterface> $products
     * @return integer
     */
    public static function calculationTotalQuantity(Collection $products): int
    {
        $totalQuantity = 0;

        /** @var ProductInterface[] $products */
        foreach ($products as $product) {
            $totalQuantity += $product->getQuantity();
        }

        return $totalQuantity;
    }
}
