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
        $email = $data->get('email');
        $password = $data->get('password');

        $user = new UserModel($email, $password);

        return $user;
    }
}
