<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CourseType;
use App\Repository\CourseRepository;
use App\Service\NotificationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/course', name: 'app_course_')]
class CourseController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function all(CourseRepository $courseRepository): Response
    {
        return $this->render('course/list.html.twig', [
            'title' => 'CourseFixtures List',
            'courses' => $courseRepository->findLastCoursesFilteredByDuration(4)
        ]);
    }

    #[Route('/add', name: 'add', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_ADMIN")]
    public function add(
        Request $request,
        EntityManagerInterface $em,
        NotificationService $notificationService
    ): Response
    {
        $course = new Course();
        $courseForm = $this->createForm(CourseType::class, $course);

        dump($this->getUser());

        $isSuperAdmin = $this->isGranted("ROLE_SUPER_ADMIN");
        dump($isSuperAdmin);

        $notificationService->sendMail($this->getUser());

        $courseForm->handleRequest($request);
        // Test de soumission et de validation
        if ($courseForm->isSubmitted() && $courseForm->isValid()) {
            $em->persist($course);
            $em->flush();
            $this->addFlash('success', 'Cours ajoute avec succes !!');
            return $this->redirectToRoute('app_course_list');
        }

        return $this->render('course/add.html.twig', [
            'title' => 'CourseFixtures add',
            'formCourse' => $courseForm
        ]);
    }

    #[Route('/insert-data', name: 'insert', methods: ['GET'])]
    public function insert(EntityManagerInterface $em) : Response
    {
        $course = new Course();
        $course->setName('CourseFixtures Tailwind')
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
    public function detail(int $id, CourseRepository $courseRepository): Response
    {
        // find : principalement pour des donnée UNIQUE
        // $course = $courseRepository->find($id);
        // findBy : pour des critères multiples (résultats multiples)

        // findOneBy : pour des critères multiples
        $course = $courseRepository->findOneBy(['id' => $id, 'isPublished' => true]);

        if (!$course) {
            throw $this->createNotFoundException('Ce cours n\'existe pas !!');
        }
        return $this->render('course/detail.html.twig', [
            'title' => 'CourseFixtures detail',
            'course' => $course
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
            'title' => 'CourseFixtures edit',
        ]);
    }
}
