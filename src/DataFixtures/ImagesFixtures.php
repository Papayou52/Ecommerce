<?php

namespace App\DataFixtures;

use App\Entity\Images;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Provider\Image;
use App\Entity\Products; //<-- Ajout pour allé chercher la class

class ImagesFixtures extends Fixture implements DependentFixtureInterface //Implémente la Dependence qui sera effective via une fonction public
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i=1; $i <= 100  ; $i++) { 
            $image = new Images();
            $image->setName($faker->image(null,640,480));
            $product=$this->getReference('prod-'.rand(1,10),Products::class);
            $image->setProducts($product);
            $manager->persist($image);
        
            

        }

        $manager->flush();

        
    }
    // Permet la dépendance à Products
    public function getDependencies(): array
    {
        return [
            ProductsFixtures::class
        ];
    }
}
