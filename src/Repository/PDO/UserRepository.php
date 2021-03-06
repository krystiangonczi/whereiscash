<?php

namespace d0niek\Whereiscash\Repository\PDO;

use d0niek\Whereiscash\Model\Model;
use d0niek\Whereiscash\Model\UserFactory;
use d0niek\Whereiscash\Repository\UserRepositoryInterface;
use Ds\Map;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class UserRepository extends Repository implements UserRepositoryInterface
{
    protected $model = 'User';
    protected $table = 'users';
    protected $idField = 'user_id';
    protected $fields = [
        'user_id',
        'email',
        'password',
        'budget'
    ];
    protected $insertFields = [
        'email',
        'password'
    ];

    public function save(Model $model): Model
    {
        /** @var \d0niek\Whereiscash\Model\UserModel $user */
        $user = $model;
        if ($user->getId() === 0) {
            $user = $this->saveData([$user->getEmail(), $user->getPassword()]);
        } else {
            $this->updateData($user->getId(), [
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'budget' => $user->getBudget()
            ]);
        }

        return $user;
    }

    protected function createModel(array $dbData): Model
    {
        $data = new Map($dbData);
        $userFactory = new UserFactory();
        /** @var \d0niek\Whereiscash\Model\UserModel $user */
        $user = $userFactory->create($data);
        $user->setId($dbData['user_id']);
        $user->setBudget($dbData['budget']);

        return $user;
    }
}
