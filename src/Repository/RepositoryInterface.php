<?php

namespace d0niek\Whereiscash\Repository;

use d0niek\Whereiscash\Model\Model;
use Ds\Vector;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
interface RepositoryInterface
{
    /**
     * @param mixed $id
     *
     * @return \d0niek\Whereiscash\Model\Model
     * @throws \d0niek\Whereiscash\Exception\ModelNotFoundException
     */
    public function find($id): Model;

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return \d0niek\Whereiscash\Model\Model
     * @throws \d0niek\Whereiscash\Exception\ModelNotFoundException
     */
    public function findOneBy(string $field, $value): Model;

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return \Ds\Vector
     */
    public function findBy(string $field, $value): Vector;

    /**
     * @param int $limit
     * @param int $offset
     * @param string $orderBy
     *
     * @return \Ds\Vector
     */
    public function findAll(int $limit = 0, int $offset = 0, string $orderBy = ''): Vector;

    /**
     * @param \d0niek\Whereiscash\Model\Model $model
     *
     * @return \d0niek\Whereiscash\Model\Model
     */
    public function save(Model $model): Model;

    /**
     * @param \d0niek\Whereiscash\Model\Model $model
     *
     * @return \d0niek\Whereiscash\Model\Model
     */
    public function remove(Model $model): Model;
}
