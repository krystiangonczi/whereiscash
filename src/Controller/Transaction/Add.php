<?php

namespace d0niek\Whereiscash\Controller\Transaction;

use d0niek\Whereiscash\Controller\Controller;
use d0niek\Whereiscash\Exception\ModelNotFoundException;
use d0niek\Whereiscash\Http\ResponseInterface;
use d0niek\Whereiscash\Model\UserModel;
use d0niek\Whereiscash\Model\TransactionFactory;
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
        $user = $this->get('user');

        if ($user === null) {
            $this->session->put('error', 'You have to be login');
            return $this->redirect('/');
        }

        if ($this->request->isPost()) {
            $cashFlow = trim($this->request->post('cash_flow'));
            $amount = trim($this->request->post('amount'));
            $category = trim($this->request->post('category'));
            $title = trim($this->request->post('title'));
            if ($this->isValid($cashFlow, (float) $amount, (int) $category, $title)) {
                $this->addTransaction($cashFlow, (float) $amount, (int) $category, $title, $user);
                return $this->redirect('/dashboard');
            }
        }

        $categoryRepository = $this->get('repository_manager')->getRepository('PDO:Category');
        $categories = $categoryRepository->findAll();

        return $this->render(
            'default',
            new Map([
                'user' => $user,
                'categories' => $categories
            ])
        );
    }

    /**
     * @param string $cashFlow
     * @param float $amount
     * @param int $category
     * @param string $title
     *
     * @return bool
     */
    private function isValid(string $cashFlow, float $amount, int $category, string $title): bool
    {
        $isFieldEmpty = $cashFlow === '' || $amount <= 0 || $category === 0;
        if ($isFieldEmpty === true) {
            $this->session->put('error', 'Fill in all fields');
            return false;
        }

        if ($cashFlow !== 'payout' && $cashFlow !== 'payin') {
            $this->session->put('error', 'Wrong value for cash-flow');
            return false;
        }

        if ($amount < 0) {
            $this->session->put('error', 'Amount can not be low then 0');
            return false;
        }

        try {
            $categoryRepository = $this->get('repository_manager')->getRepository('PDO:Category');
            $categoryRepository->findOneBy('category_id', $category);
        } catch (ModelNotFoundException $e) {
            $this->session->put('error', 'Category not found');
            return false;
        }

        if ($title !== '' && strlen($title) > 60) {
            $this->session->put('error', 'Title is to long. Max 60 characters');
            return false;
        }

        return true;
    }

    /**
     * @param string $cashFlow
     * @param float $amount
     * @param int $category
     * @param string $title
     * @param UserModel $user
     */
    private function addTransaction(
        string $cashFlow,
        float $amount,
        int $category,
        string $title,
        UserModel $user
    ): void {
        $categoryRepository = $this->get('repository_manager')->getRepository('PDO:Category');
        $category = $categoryRepository->findOneBy('category_id', $category);

        $data = new Map([
            'cashFlow' => $cashFlow !== 'payout',
            'amount' => $amount,
            'category' => $category,
            'title' => $title,
            'user' => $user,
        ]);
        $transactionFactory = new TransactionFactory();
        $transaction = $transactionFactory->create($data);
        $transactionRepository = $this->get('repository_manager')->getRepository('PDO:Transaction');
        $transactionRepository->save($transaction);

        $budget = $user->getBudget();
        $amount = $cashFlow === 'payout' ? -$amount : $amount;
        $user->setBudget($budget + $amount);
        $userRepository = $this->get('repository_manager')->getRepository('PDO:User');
        $userRepository->save($user);
    }
}
