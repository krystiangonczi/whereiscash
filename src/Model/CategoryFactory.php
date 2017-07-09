<?php

namespace d0niek\Whereiscash\Model;

use Ds\Map;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class CategoryFactory extends ModelFactory
{
    public function create(Map $data): Model
    {
        $name = $data->get('name');

        $category = new CategoryModel($name);

        return $category;
    }
}
