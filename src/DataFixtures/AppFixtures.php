<?php

namespace App\DataFixtures;

use App\Component\Utils\Aliases;
use App\Component\Utils\Utils;
use App\Entity\CheckType;
use App\Entity\Image;
use App\Entity\OrderStatus;
use App\Entity\PaymentType;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct(private readonly string $workingDir)
    {
    }

    private const SVG_FILE_PATH = '/file/products.csv';

    public function load(ObjectManager $manager): void
    {
        foreach (Aliases::ORDER_STATUSES as $status) {
            $orderStatusEntity = new OrderStatus();
            $orderStatusEntity
                ->setValue($status['value'])
                ->setDescription($status['description'])
                ->setCode($status['code']);

            $manager->persist($orderStatusEntity);
        }

        foreach (Aliases::PAYMENT_TYPE as $paymentType) {
            $paymentTypeEntity = new PaymentType();
            $paymentTypeEntity
                ->setValue($paymentType['value'])
                ->setDescription($paymentType['description'])
                ->setCode($paymentType['code']);

            $manager->persist($paymentTypeEntity);
        }

        foreach (Aliases::CHECK_TYPE as $checkType) {
            $checkTypeEntity = new CheckType();
            $checkTypeEntity
                ->setValue($checkType['value'])
                ->setDescription($checkType['description'])
                ->setCode($checkType['code']);

            $manager->persist($checkTypeEntity);
        }

        $products = Utils::convertCsvToArray($this->workingDir . self::SVG_FILE_PATH);

        foreach ($products as $product) {
            $image = new Image();
            $image
                ->setFileName($product[5])
                ->setPath($product[4]);

            $productEntity = new Product();
            $productEntity
                ->setPrice((float) $product[0])
                ->setTitle($product[1])
                ->setDescription($product[2])
                ->setAuthor($product[3])
                ->addImage($image)
                ->setUrl($product[6]);

            $manager->persist($productEntity);
        }

        $manager->flush();
    }
}
