<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $passwordEncoder) {}

    public function load(ObjectManager $manager): void
    {
        $admin = new Users();
        $admin->setEmail('admin@gmail.com');
        $admin->setLastname('Widow');
        $admin->setFirstname('Black');
        $admin->setAdress('15 av M.Rival');
        $admin->setZipcode('84000');
        $admin->setCity('Vers Avignon');
        $admin->setPassword(
            $this->passwordEncoder->hashPassword($admin,'admin')
        );
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        $faker = Factory::create('fr_FR');

        for ($i=0; $i <= 5 ; $i++) { 
            $user = new Users();
            $user->setEmail($faker->email);
            $user->setLastname($faker->lastName);
            $user->setFirstname($faker->firstName);
            $user->setAdress($faker->streetAddress);
            $user->setZipcode(str_replace(' ','', $faker->postcode));
            $user->setCity($faker->city);
            $user->setPassword(
                $this->passwordEncoder->hashPassword($user,'user')
            );
            

        $manager->persist($user);
        }

        $manager->flush();
    }
}
