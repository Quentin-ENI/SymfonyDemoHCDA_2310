<?php

namespace App\Service;

use App\Entity\Course;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;

class TrainingService
{
    private CourseRepository $courseRepository;

    public function __construct(
        CourseRepository $courseRepository
    ) {
        $this->courseRepository = $courseRepository;
    }

    public function getDuration(): int {
        $course1 = $this->courseRepository->find(98);
        $course2 = $this->courseRepository->find(99);
        $course3 = $this->courseRepository->find(100);

        $totalDuration = $course1->getDuration() + $course2->getDuration() + $course3->getDuration();

        return $totalDuration;
    }

    public function reduce(string $text, int $lenghtMax = 10) {
        if (mb_strlen($text) > $lenghtMax) {
            $text = mb_substr($text, 0, $lenghtMax - 3) . '...';
        }
        return $text;
    }
}