<?php

namespace App\DataFixtures;

use App\Component\Utils\Aliases;
use App\Component\Utils\Utils;
use App\Entity\OrderStatus;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct(private readonly string $workingDir)
    {
    }

    const SVG_FILE_PATH = '/file/products.csv';

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

        $products = Utils::convertCsvToArray($this->workingDir . self::SVG_FILE_PATH);

        foreach ($products as $product) {
            $productEntity = new Product();
            $productEntity
                ->setPrice((float) $product[0])
                ->setTitle($product[1])
                ->setDescription($product[2])
                ->setAuthor($product[3])
                ->setImage($product[4])
                ->setUrl($product[5]);

            $manager->persist($productEntity);
        }

        $manager->flush();
    }
}
