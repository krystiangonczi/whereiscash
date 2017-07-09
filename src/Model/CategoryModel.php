<?php

namespace d0niek\Whereiscash\Model;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class CategoryModel extends Model
{
    /**
     * @var string
     */
    private $name;

    /**
     * UserModel constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        parent::__construct(0);
    }

    //region Getters & Setters

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    //endregion Getters & Setters
}
