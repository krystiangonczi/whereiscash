<?php

namespace d0niek\Whereiscash\Controller\Post;

use d0niek\Whereiscash\Controller\Controller;
use d0niek\Whereiscash\Http\ResponseInterface;
use d0niek\Whereiscash\Model\PostFactory;
use d0niek\Whereiscash\Model\UserModel;
use Ds\Map;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class Add extends Controller
{
    /**
     * @return \d0niek\Whereiscash\Http\ResponseInterface
     */
    public function execute(): ResponseInterface
    {
        if ($this->request->isPost()) {
            $text = trim($this->request->post('text'));
            $text = preg_replace("/\R+/", "\n", $text);
            $login = $this->request->post('login', '');
            $user = $this->get('user');
            if ($this->isValid($text, $login, $user)) {
                $this->addPost($text, $login, $user);
            }
        }

        return $this->redirect('/');
    }

    /**
     * @param string $text
     * @param string $login
     * @param \d0niek\Whereiscash\Model\UserModel|null $user
     *
     * @return bool
     */
    private function isValid(string $text, string $login, ?UserModel $user): bool
    {
        $isFieldEmpty = $text === '' || ($login === '' && $user === null);
        if ($isFieldEmpty === true) {
            $this->session->put('error', 'Fill in all fields');
            return false;
        }

        if ($user !== null) {
            $login = '';
        }

        if (strlen($login) > 30) {
            $this->session->put('error', 'Login is to long. Max 30 characters');
            return false;
        }

        return true;
    }

    /**
     * @param string $text
     * @param string $login
     * @param \d0niek\Whereiscash\Model\UserModel|null $user
     */
    private function addPost(string $text, string $login, ?UserModel $user): void
    {
        $data = new Map([
            'text' => $text,
            'login' => $login,
            'author' => $user,
        ]);
        $postFactory = new PostFactory();
        $post = $postFactory->create($data);
        /** @var \d0niek\Whereiscash\Repository\PostRepositoryInterface $postRepository */
        $postRepository = $this->get('repository_manager')->getRepository('PDO:Post');
        $postRepository->save($post);
    }
}
