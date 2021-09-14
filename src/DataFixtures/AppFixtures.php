<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function __construct()
    {
        $this->faker = Factory::create();
    }
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i < 10 ; $i++) { 
            $article = new Post();
            $article->setTitle($this->faker->words(3, true))
                    ->setContent($this->faker->text(300))
                    ->setCreatedAt($this->faker->dateTime());
            $manager->persist($article);
        }
        $manager->flush();
    }
}
