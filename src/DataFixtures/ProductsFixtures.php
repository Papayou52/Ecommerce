<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Products;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductsFixtures extends Fixture
{
    
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i=1; $i <= 10  ; $i++) { 
            $product = new Products();
            $product->setName($faker->text(5));
            $product->setPrice($faker->numberBetween(900,150000));
            $product->setStock($faker->numberBetween(0.10));
            
            // On gére la categorie
            // On récupére les ref de CategoriesFixtures 
            $category = $this->getReference('cat-' . rand(1, 8),Categories::class); // La fonction prend 2 param ici et pas 2 comme sur la video
            $product->setCategories($category);
        

            $this->setReference('prod-'.$i,$product);
             $manager->persist($product);

        }

        $manager->flush();
    }


    
}
