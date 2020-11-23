<?php

namespace App\DataFixtures;

use App\Entity\Game;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class GameFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        
        $faker = Faker\Factory::create('fr_FR');

        //Generate 15 fake games
        for ($i=0; $i < 50; $i++) {
            $game = new Game();
            $game->setName($faker->name);
            $game->setDateAdd($faker->dateTimeBetween('-2 years','now'));
            $game->setDescription($faker->text(25));
            $game->setUser($this->getReference('user'.random_int(0 ,UserFixtures::USER_COUNT - 1)));

            $slugs = array_keys(CategoryFixtures::CATEGORIES);
            $slugCategory = $slugs[random_int(0, count($slugs) - 1)];
            $category = $this->getReference('category_'.$slugCategory);

            $game->setCategory($category);

            $this->addReference('product'.$i, $game);


            $manager->persist($game);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            CategoryFixtures::class
        ];
    }
}
