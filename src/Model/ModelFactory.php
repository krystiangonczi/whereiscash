<?php

namespace d0niek\Whereiscash\Model;

use Ds\Map;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
abstract class ModelFactory
{
    /**
     * @param \Ds\Map $data
     *
     * @return \d0niek\Whereiscash\Model\Model
     */
    abstract public function create(Map $data): Model;
}
