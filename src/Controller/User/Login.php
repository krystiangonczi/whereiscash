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
            $email = $this->request->post('email');
            $password = $this->request->post('password');
            if ($this->isValid($email, $password)) {
                $loginResponse = $this->login($email, $password);
                return $loginResponse;
            }
        }

        return $this->render('user:login');
    }

    /**
     * @param string $email
     * @param string $password
     *
     * @return bool
     */
    private function isValid(string $email, string $password): bool
    {
        $isFieldEmpty = $email === '' || $password === '';
        if ($isFieldEmpty === true) {
            $this->session->put('error', 'Fill in all fields');
            return false;
        }

        try {
            /** @var \d0niek\Whereiscash\Repository\UserRepositoryInterface $userRepository */
            $userRepository = $this->get('repository_manager')->getRepository('PDO:User');
            $userRepository->findOneBy('email', $email);
        } catch (ModelNotFoundException $e) {
            $this->session->put('error', 'Login or password is invalid');

            return false;
        }

        return true;
    }

    /**
     * @param string $email
     * @param string $password
     *
     * @return \d0niek\Whereiscash\Http\ResponseInterface
     */
    private function login(string $email, string $password): ResponseInterface
    {
        /** @var \d0niek\Whereiscash\Repository\UserRepositoryInterface $userRepository */
        $userRepository = $this->get('repository_manager')->getRepository('PDO:User');
        /** @var \d0niek\Whereiscash\Model\UserModel $user */
        $user = $userRepository->findOneBy('email', $email);

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
