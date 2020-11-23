<?php

namespace App\DataFixtures;

use App\Entity\Game;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class GameFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        
        $faker = Faker\Factory::create('fr_FR');

        //Generate 15 fake games
        for ($i=0; $i < 50; $i++) { 
            $game = new Game();
            $game->setName($faker->name);
            $game->setDateAdd($faker->datetime());
            $game->setDescription($faker->text(25));

            $manager->persist($game);
        }

        $manager->flush();
    }
}
