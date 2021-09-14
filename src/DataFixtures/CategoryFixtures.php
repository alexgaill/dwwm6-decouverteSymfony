<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    public function __construct()
    {
        $this->faker = Factory::create();
    }
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i <5 ; $i++) { 
            $category = new Categorie();
            $category->setTitle($this->faker->words(3, true));

            $manager->persist($category);
        }

        $manager->flush();
    }
}
