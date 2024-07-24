<?php

namespace App\Controller;

use App\Entity\Course;
use Doctrine\ORM\EntityManagerInterface;
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
        return $this->render('course/add.html.twig', [
            'title' => 'Course add',
        ]);
    }

    #[Route('/insert-data', name: 'insert', methods: ['GET'])]
    public function insert(EntityManagerInterface $em) : Response
    {
        $course = new Course();
        $course->setName('Course Tailwind')
            ->setContent('Content Tailwind')
            ->setDuration(2);
        // Etape obligatoire pour l'insertion seulement
        $em->persist($course);
        // Avant le flush
        dump('Avant le flush', $course);

        // Executer l'insertion
        $em->flush();

        dump('Après le 1er flush', $course);

        // Modification de l'entité
        $course->setDuration(1);
        // Executer l'insertion
        $em->flush();

        dump('Après le 2nd flush', $course);

        //  Suppression de l'entité
        $em->remove($course);
        // Executer la suppression
        $em->flush();

        dd($course);
        // Redirect to
        return $this->redirectToRoute('app_course_show', ['id' => $course->getId()]);
    }
    #[Route('/{id<\d+>}', name: 'show', methods: ['GET'])]
    public function detail(int $id, Request $request): Response
    {
        dump($request);
        dump($id);
        // dd($id); // != de dump
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
