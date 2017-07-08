<?php

namespace d0niek\Whereiscash\Repository\PDO;

use d0niek\Whereiscash\Model\Model;
use d0niek\Whereiscash\Model\PostFactory;
use d0niek\Whereiscash\Model\UserModel;
use d0niek\Whereiscash\Repository\PostRepositoryInterface;
use Ds\Map;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class PostRepository extends Repository implements PostRepositoryInterface
{
    protected $model = 'Post';
    protected $table = 'posts';
    protected $idField = 'post_id';
    protected $fields = [
        'post_id',
        'user_id',
        'login',
        'text',
        'created_at'
    ];
    protected $insertFields = [
        'user_id',
        'login',
        'text'
    ];

    public function save(Model $model): Model
    {
        /** @var \d0niek\Whereiscash\Model\PostModel $post */
        $post = $model;
        $userId = $post->getAuthor() ? $post->getAuthor()->getId() : null;
        $post = $this->saveData([$userId, $post->getLogin(), $post->getText()]);

        return $post;
    }

    public function countPost(): int
    {
        $sql = 'SELECT COUNT(*) AS all_posts FROM ' . $this->table;
        $sth = $this->executeQuery($sql);
        $result = $sth->fetch(\PDO::FETCH_ASSOC);

        return (int)$result['all_posts'];
    }

    protected function createModel(array $dbData): Model
    {
        $dbData['author'] = $this->getAuthor($dbData['user_id']);
        $data = new Map($dbData);
        $postFactory = new PostFactory();
        /** @var \d0niek\Whereiscash\Model\PostModel $post */
        $post = $postFactory->create($data);
        $post->setId($dbData['post_id']);

        return $post;
    }

    /**
     * @param int|null $authorId
     *
     * @return \d0niek\Whereiscash\Model\UserModel|null
     */
    private function getAuthor(?int $authorId): ?UserModel
    {
        if ($authorId === null) {
            return null;
        }

        $userRepository = $this->repositoryManager->getRepository('PDO:User');
        /** @var \d0niek\Whereiscash\Model\UserModel $author */
        $author = $userRepository->find($authorId);

        return $author;
    }
}
