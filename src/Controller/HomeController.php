<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $people = [
            [
                'name' => 'Joe',
                'age' => 40,
                'city' => 'Nantes',
            ],
            [
                'name' => 'Jane',
                'age' => 47,
                'city' => 'Paris',
            ],
            [
                'name' => 'John',
                'age' => 40,
                'city' => 'Rennes',
            ],
        ];

        return $this->render('home/index.html.twig', [
            'title' => 'Home Page',
            'gens' => $people
        ]);
    }

    #[Route('/test', name: 'app_test')]
    public function test(): Response
    {
        return $this->render('home/test.html.twig', [
            'title' => 'Test Page'
        ]);
    }
}
