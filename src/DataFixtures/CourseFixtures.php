<?php

namespace App\DataFixtures;

use App\Entity\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CourseFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Utilisation de FakerPHP
        $faker = \Faker\Factory::create('fr_FR');

        $course1 = new Course();
        $course1->setName('Course Fixtures')
            ->setContent('Content Fixtures')
            ->setDuration(1)
            ->addCategory($this->getReference("category-1"));
        $course2 = new Course();
        $course2->setName('Course Doctrine')
            ->setContent('Content Doctrine')
            ->setDuration(7)
            ->addCategory($this->getReference("category-2"));
        $course3 = new Course();
        $course3->setName('Course QueryBuilder')
            ->setContent('Content QueryBuilder')
            ->setDuration(2)
            ->addCategory($this->getReference("category-1"));
        $course4 = new Course();
        $course4->setName('Course Faker')
            ->setContent('Content Faker')
            ->setDuration(10)
            ->addCategory($this->getReference("category-2"));

        // Persistences
        $manager->persist($course1);
        $manager->persist($course2);
        $manager->persist($course3);
        $manager->persist($course4);

        // Avec Faker
        for ($i = 0; $i < 10; $i++) {
            $course = new Course();
            $course
                ->setName($faker->sentence(3))
                ->setContent($faker->sentence(10))
                ->setDuration($faker->numberBetween(1, 10))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable(
                    $faker->dateTimeBetween('-1 year', 'now'))
                );
            $manager->persist($course);
        }

        // Executer l'insertion
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class
        ];
    }
}
