<?php

namespace d0niek\Whereiscash\Repository\PDO;

use d0niek\Whereiscash\Model\Model;
use d0niek\Whereiscash\Model\UserModel;
use d0niek\Whereiscash\Model\CategoryModel;
use d0niek\Whereiscash\Model\TransactionFactory;
use d0niek\Whereiscash\Repository\TransactionRepositoryInterface;
use Ds\Map;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class TransactionRepository extends Repository implements TransactionRepositoryInterface
{
    protected $model = 'Transaction';
    protected $table = 'transactions';
    protected $idField = 'transaction_id';
    protected $fields = [
        'transaction_id',
        'user_id',
        'category_id',
        'title',
        'amount',
        'cash_flow',
        'created_at',
    ];
    protected $insertFields = [
        'user_id',
        'category_id',
        'title',
        'amount',
        'cash_flow',
        'created_at',
    ];

    public function save(Model $model): Model
    {
        /** @var \d0niek\Whereiscash\Model\TransactionModel $transaction */
        $transaction = $model;
        $transaction = $this->saveData([
            $transaction->getUser()->getId(),
            $transaction->getCategory()->getId(),
            $transaction->getTitle(),
            $transaction->getAmount(),
            $transaction->getCashFlow() ? 1 : 0,
            $transaction->getCreatedAt()->format('Y-m-d H:i:s'),
        ]);

        return $transaction;
    }

    protected function createModel(array $dbData): Model
    {
        $dbData['user'] = $this->getUser($dbData['user_id']);
        $dbData['category'] = $this->getCategory($dbData['category_id']);
        $dbData['cashFlow'] = (bool) $dbData['cash_flow'];
        $data = new Map($dbData);
        $transactionFactory = new TransactionFactory();
        $transaction = $transactionFactory->create($data);
        $transaction->setCreatedAt(\DateTime::createFromFormat('Y-m-d H:i:s', $dbData['created_at']));

        return $transaction;
    }

    /**
     * @param int $userId
     *
     * @return \d0niek\Whereiscash\Model\UserModel
     */
    private function getUser(int $userId): UserModel
    {
        $userRepository = $this->repositoryManager->getRepository('PDO:User');
        $user = $userRepository->find($userId);

        return $user;
    }

    /**
     * @param int $categoryId
     *
     * @return \d0niek\Whereiscash\Model\CategoryModel
     */
    private function getCategory(int $categoryId): CategoryModel
    {
        $categoryRepository = $this->repositoryManager->getRepository('PDO:Category');
        $category = $categoryRepository->find($categoryId);

        return $category;
    }
}
