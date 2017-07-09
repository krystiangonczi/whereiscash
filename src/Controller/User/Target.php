<?php

namespace d0niek\Whereiscash\Controller\User;

use d0niek\Whereiscash\Controller\Controller;
use d0niek\Whereiscash\Http\ResponseInterface;
use d0niek\Whereiscash\Model\UserModel;
use d0niek\Whereiscash\Model\TargetFactory;
use Ds\Map;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class Target extends Controller
{
    public function execute(): ResponseInterface
    {
        $user = $this->get('user');

        if ($user === null) {
            $this->session->put('error', 'You have to be login');
            return $this->redirect('/');
        }

        if ($this->request->isPost()) {
            $amount = $this->request->post('amount');
            $start = $this->request->post('start');
            $end = $this->request->post('end');
            if ($this->isValid((float) $amount, $start, $end)) {
                $this->addTarget((float) $amount, $start, $end, $user);
                return $this->redirect('/dashboard');
            }
        }

        return $this->render('target');
    }

    /**
     * @param float $amount
     * @param string $start
     * @param string $end
     *
     * @return bool
     */
    private function isValid(float $amount, string $start, string $end): bool
    {
        $isFieldEmpty = $amount <= 0;// || $start === '' || $end === '';
        if ($isFieldEmpty === true) {
            $this->session->put('error', 'Fill in all fields');
            return false;
        }

        $start = \DateTime::createFromFormat('Y-m-d', $start);
        if ($start === false) {
            $this->session->put('error', 'Wrong format start date');
            return false;
        }

        $end = \DateTime::createFromFormat('Y-m-d', $end);
        if ($end === false) {
            $this->session->put('error', 'Wrong format end date');
            return false;
        }

        if ($end <= $start) {
            $this->session->put('error', 'End date can not be lower than start date');
            return false;
        }

        return true;
    }

    /**
     * @param float $amount
     * @param string $start
     * @param string $end
     * @param UserModel $user
     */
    private function addTarget(float $amount, string $start, string $end, UserModel $user): void
    {
        $start = \DateTime::createFromFormat('Y-m-d', $start);
        $end = \DateTime::createFromFormat('Y-m-d', $end);

        $data = new Map([
            'amount' => $amount,
            'user' => $user,
            'start' => $start,
            'end' => $end,
        ]);
        $targetFactory = new TargetFactory();
        $target = $targetFactory->create($data);
        $targetRepository = $this->get('repository_manager')->getRepository('PDO:Target');
        $targetRepository->save($target);
    }
}
