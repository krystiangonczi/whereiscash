<?php

namespace d0niek\Whereiscash\Model;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class TargetModel extends Model
{
    /**
     * @var \d0niek\Whereiscash\Model\UserModel
     */
    private $user;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var \DateTime
     */
    private $startAt;

    /**
     * @var \DateTime
     */
    private $endAt;

    /**
     * @var bool
     */
    private $finished;

    /**
     * @param UserModel $user
     * @param float $amount
     * @param \DateTime $start
     * @param \DateTime $end
     */
    public function __construct(UserModel $user, float $amount, \DateTime $start, \DateTime $end)
    {
        $this->user = $user;
        $this->amount = $amount;
        $this->startAt = $start;
        $this->endAt = $end;
        $this->finished = false;
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
     * @return \DateTime
     */
    public function getStartAt(): \DateTime
    {
        return $this->startAt;
    }

    /**
     * @param \DateTime $startAt
     */
    public function setStartAt(\DateTime $startAt): void
    {
        $this->startAt = $startAt;
    }

    /**
     * @return \DateTime
     */
    public function getEndAt(): \DateTime
    {
        return $this->endAt;
    }

    /**
     * @param \DateTime $endAt
     */
    public function setEndAt(\DateTime $endAt): void
    {
        $this->endAt = $endAt;
    }

    /**
     * @return bool
     */
    public function isFinished(): bool
    {
        return $this->finished;
    }

    /**
     * @param bool $finished
     */
    public function setFinished(bool $finished): void
    {
        $this->finished = $finished;
    }

    //endregion Getters & Setters
}
