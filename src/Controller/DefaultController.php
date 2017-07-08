<?php

namespace d0niek\Whereiscash\Controller;

use d0niek\Whereiscash\Http\ResponseInterface;
use Ds\Map;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class DefaultController extends Controller
{
    private const LIMIT_PER_PAGE = 50;

    public function execute(): ResponseInterface
    {
        $userLogin = $this->get('user') ? $this->get('user')->getLogin() : 'Guest';
        $offset = $this->getOffset();
        /** @var \d0niek\Whereiscash\Repository\PostRepositoryInterface $postRepository */
        $postRepository = $this->get('repository_manager')->getRepository('PDO:Post');
        $posts = $postRepository->findAll(self::LIMIT_PER_PAGE, $offset, 'created_at DESC');
        $allPosts = $postRepository->countPost();
        $pages = $allPosts / self::LIMIT_PER_PAGE;

        return $this->render(
            'default',
            new Map(
                [
                    'name' => $userLogin,
                    'posts' => $posts,
                    'pages' => $pages
                ]
            )
        );
    }

    /**
     * @return int
     */
    private function getOffset(): int
    {
        $page = $this->request->get('page', 1) - 1;
        if ($page < 0) {
            $page = 0;
        }

        $offset = $page * self::LIMIT_PER_PAGE;

        return $offset;
    }
}
