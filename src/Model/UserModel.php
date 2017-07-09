<?php

namespace d0niek\Whereiscash\Model;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class UserModel extends Model
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var float
     */
    private $budget;

    /**
     * UserModel constructor.
     *
     * @param string $email
     * @param string $password
     */
    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
        $this->budget = 0;
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
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return float
     */
    public function getBudget(): float
    {
        return $this->budget;
    }

    /**
     * @param float $budget
     */
    public function setBudget(float $budget): void
    {
        $this->budget = $budget;
    }

    //endregion Getters & Setters
}
