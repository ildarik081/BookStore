<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Фикстуры для наполения товаров
 */
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
    }
}
