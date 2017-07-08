<?php

namespace d0niek\Whereiscash\Controller\User;

use d0niek\Whereiscash\Controller\Controller;
use d0niek\Whereiscash\Exception\ModelNotFoundException;
use d0niek\Whereiscash\Http\ResponseInterface;
use d0niek\Whereiscash\Model\UserFactory;
use Ds\Map;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class Register extends Controller
{
    /**
     * @return \d0niek\Whereiscash\Http\ResponseInterface
     */
    public function execute(): ResponseInterface
    {
        if ($this->get('user') !== null) {
            return $this->redirect('/');
        }

        if ($this->request->isPost()) {
            $login = $this->request->post('login');
            $password = $this->request->post('password');
            $repeatPassword = $this->request->post('repeat_password');
            if ($this->isValid($login, $password, $repeatPassword)) {
                $this->registerAndLogin($login, $password);
                return $this->redirect('/');
            }
        }

        return $this->render('user:register');
    }

    /**
     * @param string $login
     * @param string $password
     * @param string $repeatPassword
     *
     * @return bool
     */
    private function isValid(string $login, string $password, string $repeatPassword): bool
    {
        $isFieldEmpty = $login === '' || $password === '' || $repeatPassword === '';
        if ($isFieldEmpty === true) {
            $this->session->put('error', 'Fill in all fields');
            return false;
        }

        if (strlen($login) > 30) {
            $this->session->put('error', 'Login is to long. Max 30 characters');
            return false;
        }

        try {
            /** @var \d0niek\Whereiscash\Repository\UserRepositoryInterface $userRepository */
            $userRepository = $this->get('repository_manager')->getRepository('PDO:User');
            $userRepository->findOneBy('login', $login);
            $this->session->put('error', 'Login is in use.');
        } catch (ModelNotFoundException $e) {
            if ($password === $repeatPassword) {
                return true;
            }

            $this->session->put('error', 'Passwords do not match.');
        }

        return false;
    }

    /**
     * @param string $login
     * @param string $password
     */
    private function registerAndLogin(string $login, string $password): void
    {
        $passwordHash = $this->get('password_hash')->hash($password);
        $data = new Map([
            'login' => $login,
            'password' => $passwordHash,
        ]);
        $userFactory = new UserFactory();
        $user = $userFactory->create($data);
        /** @var \d0niek\Whereiscash\Repository\UserRepositoryInterface $userRepository */
        $userRepository = $this->get('repository_manager')->getRepository('PDO:User');
        $user = $userRepository->save($user);
        $this->session->put('user', $user);
    }
}
