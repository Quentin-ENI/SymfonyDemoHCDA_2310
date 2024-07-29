<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $category1 = new Category();
        $category1->setName("Back-end");
        $this->addReference("category-1", $category1);

        $category2 = new Category();
        $category2->setName("Front-end");
        $this->addReference("category-2", $category2);

        $manager->persist($category1);
        $manager->persist($category2);


        $manager->flush();
    }
}
