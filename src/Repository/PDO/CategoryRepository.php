<?php

namespace d0niek\Whereiscash\Repository\PDO;

use d0niek\Whereiscash\Model\Model;
use d0niek\Whereiscash\Model\CategoryFactory;
use d0niek\Whereiscash\Repository\UserRepositoryInterface;
use Ds\Map;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class CategoryRepository extends Repository implements UserRepositoryInterface
{
    protected $model = 'Category';
    protected $table = 'categories';
    protected $idField = 'category_id';
    protected $fields = [
        'category_id',
        'name',
    ];
    protected $insertFields = [
        'name',
    ];

    public function save(Model $model): Model
    {
        /** @var \d0niek\Whereiscash\Model\CategoryModel $category */
        $category = $model;
        $category = $this->saveData([$category->getName()]);

        return $category;
    }

    protected function createModel(array $dbData): Model
    {
        $data = new Map($dbData);
        $categoryFactory = new CategoryFactory();
        /** @var \d0niek\Whereiscash\Model\CategoryModel $category */
        $category = $categoryFactory->create($data);
        $category->setId($dbData['category_id']);

        return $category;
    }
}
