<?php

namespace d0niek\Whereiscash\Model;

use Ds\Map;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class UserFactory extends ModelFactory
{
    public function create(Map $data): Model
    {
        $login = $data->get('login');
        $password = $data->get('password');

        $user = new UserModel($login, $password);

        return $user;
    }
}
