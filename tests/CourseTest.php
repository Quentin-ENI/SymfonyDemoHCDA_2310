<?php

namespace App\Tests;

use App\Entity\Course;
use PHPUnit\Framework\TestCase;

class CourseTest extends TestCase
{
    /*
     * Conventions:
     * - Mettre le mot-clef test
     * - Mettre un _
     * - Donner le scénario avec "given"
     * - Mettre un _
     * - Indiquer le nom de la méthode testée
     * - Mettre un _
     * - Mettre le résultat attendu
     *
     */
    public function test_givenChoiceFormatIsZero_getFormattedCreatedAt_returnMonthInLetters(): void
    {
        $course = new Course();
        $course->setCreatedAt(new \DateTimeImmutable("10-10-2010"));
        $this->assertEquals("10-Oct-2010", $course->getFormattedCreatedAt(0));
    }

    public function test_givenChoiceFormatIsOne_getFormattedCreatedAt_returnMonthInNumbers(): void
    {
        $course = new Course();
        $course->setCreatedAt(new \DateTimeImmutable("10-10-2010"));
        $this->assertEquals("10-10-2010", $course->getFormattedCreatedAt(1));
    }
}
