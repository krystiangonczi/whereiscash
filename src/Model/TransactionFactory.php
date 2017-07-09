<?php

namespace d0niek\Whereiscash\Model;

use Ds\Map;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class TransactionFactory extends ModelFactory
{
    public function create(Map $data): Model
    {
        $title = $data->get('title');
        $amount = $data->get('amount');
        $category = $data->get('category');
        $cashFlow = $data->get('cashFlow');
        $user = $data->get('user');

        $transaction = new TransactionModel($title, $amount, $category, $cashFlow, $user);

        return $transaction;
    }
}
