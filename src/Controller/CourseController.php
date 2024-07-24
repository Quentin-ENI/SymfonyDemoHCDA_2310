<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/course', name: 'app_course_')]
class CourseController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function all(): Response
    {
        return $this->render('course/list.html.twig', [
            'title' => 'Course List',
        ]);
    }

    #[Route('/add', name: 'add', methods: ['GET', 'POST'])]
    public function add(): Response
    {
        return $this->render('course/detail.html.twig', [
            'title' => 'Course add',
        ]);
    }

    #[Route('/{id<\d+>}', name: 'show', methods: ['GET'])]
    public function detail(int $id, Request $request): Response
    {
        return $this->render('course/detail.html.twig', [
            'title' => 'Course detail',
        ]);
    }

    //    #[Route('/detail/{id<\d+>}', name: 'detail')]
    //    #[Route('/{id}/detail', name: 'detail', requirements: ['id' => '\d+'])]
    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(int $id, Request $request): Response
    {
        dump($request);
        // dd($id); // != de dump
        return $this->render('course/edit.html.twig', [
            'title' => 'Course edit',
        ]);
    }
}
