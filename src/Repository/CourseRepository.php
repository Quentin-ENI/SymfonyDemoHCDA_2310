<?php

namespace App\Repository;

use App\Entity\Course;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Course>
 */
class CourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }

    public function findLastCoursesFilteredByDuration(int $duration = 3): array
    {
        // DQL
        //        $em = $this->getEntityManager();
        //        $dql = "SELECT c
        //            FROM App\Entity\CourseFixtures c
        //            WHERE c.duration > :duration
        //            ORDER BY c.createdAt DESC";
        //        $q = $em->createQuery($dql);

        // Avec QueryBuilder
        $queryBuilder = $this->createQueryBuilder('c');
        $queryBuilder
            ->where('c.duration > :duration')
            ->orderBy('c.createdAt', 'DESC')
            ->setParameter('duration', $duration);

        // Partie Commune au 2 requêtes
        $q = $queryBuilder->getQuery();
        return $q->getResult();
    }

}
