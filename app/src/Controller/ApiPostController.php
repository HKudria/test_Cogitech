<?php

namespace App\Controller;

use App\Repository\PostsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ApiPostController extends AbstractController
{

    public function __construct(
        private PostsRepository $postsRepository,
    )
    {
    }

    #[Route('/posts', name: 'posts')]
    public function apiPostsRender(): JsonResponse
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $output = [];
        foreach ($this->postsRepository->findAll() as $post) {
            $output[] = $serializer->serialize($post, 'json');
        }
        return new JsonResponse($output);
    }
}