<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    const USER_COUNT = 40;
    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder){
        $this->userPasswordEncoder = $userPasswordEncoder;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $password = $this->userPasswordEncoder->encodePassword(new User, 'toto');

        for ($i=0; $i < self::USER_COUNT; $i++) {
            $user = new User();
            $user->setFirstname($faker->name);
            $user->setLastname($faker->lastName);
            $user->setMail($faker->email);
            $user->setDateRegister(new DateTime());
            $user->setPassword($password);
            $this->addReference('user'.$i, $user);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
