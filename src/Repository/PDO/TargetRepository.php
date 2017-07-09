<?php

namespace d0niek\Whereiscash\Repository\PDO;

use d0niek\Whereiscash\Model\Model;
use d0niek\Whereiscash\Model\UserModel;
use d0niek\Whereiscash\Model\TargetFactory;
use d0niek\Whereiscash\Model\CategoryModel;
use d0niek\Whereiscash\Model\TransactionFactory;
use d0niek\Whereiscash\Repository\TransactionRepositoryInterface;
use Ds\Map;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class TargetRepository extends Repository implements TransactionRepositoryInterface
{
    protected $model = 'Target';
    protected $table = 'targets';
    protected $idField = 'target_id';
    protected $fields = [
        'target_id',
        'user_id',
        'amount',
        'start_date',
        'end_date',
        'finished',
    ];
    protected $insertFields = [
        'user_id',
        'amount',
        'start_date',
        'end_date',
    ];

    public function save(Model $model): Model
    {
        /** @var \d0niek\Whereiscash\Model\TargetModel $target */
        $target = $model;
        $target = $this->saveData([
            $target->getUser()->getId(),
            $target->getAmount(),
            $target->getStartAt()->format('Y-m-d H:i:s'),
            $target->getEndAt()->format('Y-m-d H:i:s'),
        ]);

        return $target;
    }

    protected function createModel(array $dbData): Model
    {
        $dbData['user'] = $this->getUser($dbData['user_id']);
        $dbData['start'] = \DateTime::createFromFormat('Y-m-d H:i:s', $dbData['start_date']);
        $dbData['end'] = \DateTime::createFromFormat('Y-m-d H:i:s', $dbData['end_date']);
        $data = new Map($dbData);
        $targetFactory = new TargetFactory();
        $target = $targetFactory->create($data);

        return $target;
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
}
