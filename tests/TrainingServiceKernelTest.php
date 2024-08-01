<?php

namespace App\Tests;

use App\Service\TrainingService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TrainingServiceKernelTest extends KernelTestCase
{
    public function testSomething(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        // $routerService = static::getContainer()->get('router');
        // $myCustomService = static::getContainer()->get(CustomService::class);
    }

    public function test_reduce_data_with_length(): void {
        self::bootKernel();

        $trainingService = static::getContainer()->get(TrainingService::class);

        $content = "Texte avec beaucoup de caractères";
        $this->assertSame("Texte de...", $trainingService->reduce($content));
    }
}
