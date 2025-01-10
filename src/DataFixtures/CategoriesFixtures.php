<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoriesFixtures extends Fixture
{

    private $counter = 1;


    public function load(ObjectManager $manager): void
    {
        $parent = $this->createCategory('Informatique',null, $manager);

        $this->createCategory('Ordinateur',$parent,$manager);
        $this->createCategory('Ecran',$parent,$manager);
        $this->createCategory('Clavier',$parent,$manager);

        $parent = $this->createCategory('Marvel',null, $manager);

        $this->createCategory('Thor',$parent,$manager);
        $this->createCategory('Magneto',$parent,$manager);
        $this->createCategory('Charles Xavier',$parent,$manager);

        $manager->flush();
    }

    // Créer reference une réference de catégorie à chaque instanciation qu'on ira chercher dans ProductsFixtures
    public function createCategory(string $name, Categories $parent = null, ObjectManager $manager){
        $category = new Categories();
        $category->setName($name);
        $category->setParent($parent);
        $manager->persist($category);

        $this->addReference('cat-'.$this->counter,$category);
        $this->counter ++;

        return $category;
    }
}
