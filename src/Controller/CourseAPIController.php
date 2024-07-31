<?php

namespace App\Controller;

use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CourseAPIController extends AbstractController
{
    #[Route('/api/course', name: 'app_api_course', methods: ["GET"])]
    public function all(
        CourseRepository $courseRepository,
        SerializerInterface $serializer
    ): JsonResponse
    {
        $courses = $courseRepository->findLastCoursesFilteredByDuration(4);
        $result = $serializer->serialize(
            $courses,
            'json',
            ['groups' => 'getCourses']
        );

        return new JsonResponse($result, Response::HTTP_OK, [], true);
    }

    #[Route('/api/course/{id<\d+>}', name: 'app_api_show', methods: ['GET'])]
    public function detail(
        int $id,
        CourseRepository $courseRepository,
        SerializerInterface $serializer
    ): JsonResponse
    {
        $course = $courseRepository->findOneBy(['id' => $id, 'published' => true]);

        if (!$course) {
//            throw $this->createNotFoundException('Ce cours n\'existe pas !!');
            return $this->json("Ce cours n'existe pas", Response::HTTP_NOT_FOUND);
        }

//        $result = $serializer->serialize(
//            $course,
//            'json',
//            ['groups' => 'getCourse']
//        );
//        return new JsonResponse($result, Response::HTTP_OK, [], true);

        return $this->json($course, Response::HTTP_OK, [], ['groups' => 'getCourse']);
    }
}
