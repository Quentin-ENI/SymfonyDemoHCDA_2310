<?php

namespace App\Tests;

use App\Entity\Course;
use App\Repository\CourseRepository;
use App\Service\TrainingService;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class TrainingServiceTest extends TestCase
{
    public function test_trainingService(): void
    {
        $course1 = new Course();
        $course1->setDuration(1);

        $course2 = new Course();
        $course2->setDuration(2);

        $course3 = new Course();
        $course3->setDuration(3);

        $mock = $this->createMock(CourseRepository::class);
        $mock->expects($this->exactly(3))
            ->method('find')
            ->willReturnOnConsecutiveCalls($course1, $course2, $course3);

        $trainingService = new TrainingService($mock);
        assertEquals(6, $trainingService->getDuration());
    }
}
