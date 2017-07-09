<?php

namespace d0niek\Whereiscash\Model;

use Ds\Map;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class TargetFactory extends ModelFactory
{
    public function create(Map $data): Model
    {
        $user = $data->get('user');
        $amount = $data->get('amount');
        $start = $data->get('start');
        $end = $data->get('end');

        $target = new TargetModel($user, $amount, $start, $end);

        return $target;
    }
}
