<?php

namespace App\Controller;

use App\Entity\Course;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/course', name: 'app_api_')]
class CourseAPIController extends AbstractController
{
    #[Route('', name: 'course', methods: ["GET"])]
    public function readAll(
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

    #[Route('/{id<\d+>}', name: 'show', methods: ['GET'])]
    public function read(
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

    #[Route('/add', name: 'add', methods: ['POST'])]
    public function create(
        EntityManagerInterface $entityManager,
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): JsonResponse {
        try {
            $content = $request->getContent();
            $course = $serializer->deserialize($content, Course::class, 'json');

            $errors = $validator->validate($course);
            if (count($errors) > 0) {
                $errorsJson = $serializer->serialize($errors, 'json');
                return $this->json($errorsJson, Response::HTTP_BAD_REQUEST);
            }

            $entityManager->persist($course);
            $entityManager->flush();
        } catch (Exception $exception) {
            return $this->json("Le cours n'a pas été créé. Erreur : ". $exception->getMessage());
        }

        return $this->json("Le cours a bien été créé", Response::HTTP_CREATED);
    }

    #[Route('/update/{id}', name: 'update', requirements: ['id' => '\d+'], methods: ['PUT'])]
    public function update(
        ?Course $course,
        Request $request,
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        if (!$course) {
            return $this->json("Cours non trouvé", Response::HTTP_NOT_FOUND);
        }

        $content = $request->getContent();
        $serializer->deserialize(
            $content,
            Course::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $course]
        );
        $entityManager->flush();

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/delete/{id}', name: 'delete', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function delete(
        ?Course $course,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        if (!$course) {
            return $this->json("Cours non trouvé", Response::HTTP_NOT_FOUND);
        }

        try {
            $entityManager->remove($course);
            $entityManager->flush();
        } catch (Exception $exception) {
            return $this->json("Erreur en base de donneée. Erreur : " . $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json(null, Response::HTTP_NO_CONTENT);

    }
}
