<?php

namespace App\Controller;

use App\Repository\PostsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PostsController extends AbstractController
{

    public function __construct(
        private PostsRepository        $postsRepository,
    )
    {
    }

    #[Route('/lista', name: 'lista')]
    public function renderPosts(string $error = null): Response
    {
        return $this->render('posts/posts.html.twig', [
            'posts' => $this->postsRepository->findAll(),
            'error' => $error
        ]);
    }

    #[Route('/delete_post/{id}', name: 'delete_post')]
    public function deletePost(int $id): Response
    {
        if (!in_array('ROLE_USER', $this->getUser()?->getRoles())) {
            $this->redirectToRoute('lista', ['error' => 'User not have permission']);
        }
        $post = $this->postsRepository->findOneBy(['id' => $id]);
        if (!$post) {
            $this->redirectToRoute('lsita', ['error' => 'Post not found']);
        }
        $this->postsRepository->remove($post, true);
        $this->addFlash('info', 'Post was deleted');
        return $this->redirectToRoute('lista');
    }


}