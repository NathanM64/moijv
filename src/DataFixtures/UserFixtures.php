<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $userPasswordEncoder;

    private function __construct(UserPasswordEncoderInterface $userPasswordEncoder){
        $this->userPasswordEncoder = $userPasswordEncoder;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        //Generate 15 fake games
        for ($i=0; $i < 50; $i++) { 
            $user = new User();
            $user->setFirstname($faker->name);
            $user->setLastname($faker->datetime());
            $user->setMail($faker->email);
            $user->setDateRegister(new \DateTime());
            $user->setPassword($this->userPasswordEncoder->encodePassword($user, 'toto'));

            $manager->persist($user);
        }

        $manager->flush();
    }
}
