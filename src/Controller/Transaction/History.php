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
class History extends Controller
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

        $transactionRepository = $this->get('repository_manager')->getRepository('PDO:Transaction');
        $transactions = $transactionRepository->findBy('user_id', $user->getId());

        return $this->render(
            'history',
            new Map([
                'user' => $user,
                'history' => $transactions
            ])
        );
    }
}
