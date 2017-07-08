<?php

namespace d0niek\Whereiscash\Model;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
abstract class Model
{
    /**
     * @var mixed
     */
    protected $id;

    /**
     * Model constructor.
     *
     * @param mixed $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    //region Getters & Setters

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    //endregion Getters & Setters
}
