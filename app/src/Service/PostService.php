<?php

namespace App\Service;

use App\Entity\Posts;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PostService
{
    private const RESPONSE_SUCCESS = 200;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly HttpClientInterface    $client
    )
    {
    }

    public function parsePosts(): string
    {
        try {
            $posts = $this->parseData('https://jsonplaceholder.typicode.com/posts');
            $users = $this->parseData('https://jsonplaceholder.typicode.com/users');
        } catch (Exception) {
            return 'Error parsing data';
        }

        foreach ($posts as $post) {
            $userName = $this->getUserName($users, $post['userId']);
            if (!$userName) {
                return 'User not found';
            }
            $postEntity = (new Posts())
                ->setPostId($post['id'])
                ->setUserId($post['userId'])
                ->setBody($post['body'])
                ->setTitle($post['title'])
                ->setUserName($userName);
            $this->entityManager->persist($postEntity);
        }

        $this->entityManager->flush();

        return 'Post successful parsed';
    }

    /**
     * @throws Exception
     */
    private function parseData(string $url): array
    {
        $response = $this->client->request(
            'GET',
            $url
        );

        return $response->getStatusCode() === self::RESPONSE_SUCCESS ? $content = $response->toArray() : throw new Exception('Can\'t parsa data');
    }

    private function getUserName(array $users, int $id): string|null
    {
        foreach ($users as $user) {
            if ($user['id'] === $id) return $user['name'];
        }
        return null;
    }
}
