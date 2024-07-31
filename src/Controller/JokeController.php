<?php

namespace App\Controller;

use App\Model\Joke;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class JokeController extends AbstractController
{
    #[Route('/joke', name: 'app_joke')]
    public function index(
        SerializerInterface $serializer
    ): Response
    {
        $content = file_get_contents("https://api.chucknorris.io/jokes/random");

//        $jokeArray = $serializer->decode($content, 'json');
//        $jokeObject = $serializer->denormalize($jokeArray, Joke::class);

        $joke = $serializer->deserialize($content, Joke::class, 'json');

        return $this->render('joke/index.html.twig', [
            'joke' => $joke
        ]);
    }
}
