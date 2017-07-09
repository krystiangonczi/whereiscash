<?php

namespace d0niek\Whereiscash\Model;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class TransactionModel extends Model
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var \d0niek\Whereiscash\Model\CategoryModel
     */
    private $category;

    /**
     * @var bool
     */
    private $cashFlow;

    /**
     * @var \d0niek\Whereiscash\Model\UserModel
     */
    private $user;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @param string $title
     * @param float $amount
     * @param CategoryModel $category
     * @param bool $cashFlow
     * @param UserModel $user
     */
    public function __construct(string $title, float $amount, CategoryModel $category, bool $cashFlow, UserModel $user)
    {
        $this->title = $title;
        $this->amount = $amount;
        $this->category = $category;
        $this->cashFlow = $cashFlow;
        $this->user = $user;
        $this->createdAt = new \DateTime();
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
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return \d0niek\Whereiscash\Model\CategoryModel
     */
    public function getCategory(): CategoryModel
    {
        return $this->category;
    }

    /**
     * @param \d0niek\Whereiscash\Model\CategoryModel $category
     */
    public function setCategory(CategoryModel $category): void
    {
        $this->category = $category;
    }

    /**
     * @return bool
     */
    public function getCashFlow(): bool
    {
        return $this->cashFlow;
    }

    /**
     * @param bool $cashFlow
     */
    public function setCashFlow(bool $cashFlow): void
    {
        $this->cashFlow = $cashFlow;
    }

    /**
     * @return \d0niek\Whereiscash\Model\UserModel
     */
    public function getUser(): UserModel
    {
        return $this->user;
    }

    /**
     * @param \d0niek\Whereiscash\Model\UserModel $user
     */
    public function setUser(UserModel $user): void
    {
        $this->user = $user;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    //endregion Getters & Setters
}
