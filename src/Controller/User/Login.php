<?php

namespace d0niek\Whereiscash\Controller\User;

use d0niek\Whereiscash\Controller\Controller;
use d0niek\Whereiscash\Exception\ModelNotFoundException;
use d0niek\Whereiscash\Http\ResponseInterface;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class Login extends Controller
{
    public function execute(): ResponseInterface
    {
        if ($this->get('user') !== null) {
            return $this->redirect('/');
        }

        if ($this->request->isPost()) {
            $login = $this->request->post('login');
            $password = $this->request->post('password');
            if ($this->isValid($login, $password)) {
                $loginResponse = $this->login($login, $password);
                return $loginResponse;
            }
        }

        return $this->render('user:login');
    }

    /**
     * @param string $login
     * @param string $password
     *
     * @return bool
     */
    private function isValid(string $login, string $password): bool
    {
        $isFieldEmpty = $login === '' || $password === '';
        if ($isFieldEmpty === true) {
            $this->session->put('error', 'Fill in all fields');
            return false;
        }

        try {
            /** @var \d0niek\Whereiscash\Repository\UserRepositoryInterface $userRepository */
            $userRepository = $this->get('repository_manager')->getRepository('PDO:User');
            $userRepository->findOneBy('login', $login);
        } catch (ModelNotFoundException $e) {
            $this->session->put('error', 'Login or password is invalid');

            return false;
        }

        return true;
    }

    /**
     * @param string $login
     * @param string $password
     *
     * @return \d0niek\Whereiscash\Http\ResponseInterface
     */
    private function login(string $login, string $password): ResponseInterface
    {
        /** @var \d0niek\Whereiscash\Repository\UserRepositoryInterface $userRepository */
        $userRepository = $this->get('repository_manager')->getRepository('PDO:User');
        /** @var \d0niek\Whereiscash\Model\UserModel $user */
        $user = $userRepository->findOneBy('login', $login);

        $passwordHash = $this->get('password_hash')->hash($password);
        if ($this->isPasswordMatch($passwordHash, $user->getPassword())) {
            $this->session->put('user', $user);
            return $this->redirect('/');
        }

        $this->session->put('error', 'Login or password is invalid');

        return $this->render('user:login');
    }

    /**
     * @param string $passwordHash
     * @param string $userPassword
     *
     * @return bool
     */
    private function isPasswordMatch(string $passwordHash, string $userPassword): bool
    {
        $match = true;
        for ($i = 0; $i < strlen($passwordHash); $i++) {
            if ($passwordHash[$i] !== $userPassword[$i]) {
                $match = false;
            }
        }

        return $match;
    }
}
