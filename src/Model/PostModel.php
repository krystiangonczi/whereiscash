<?php

namespace d0niek\Whereiscash\Model;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class PostModel extends Model
{
    /**
     * @var string
     */
    private $text;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \d0niek\Whereiscash\Model\UserModel|null
     */
    private $author;

    /**
     * @var string
     */
    private $login;

    /**
     * PostModel constructor.
     *
     * @param string $text
     * @param \d0niek\Whereiscash\Model\UserModel|null $author
     * @param string $login
     * @param \DateTime $createdAt
     */
    public function __construct(string $text, \DateTime $createdAt, ?UserModel $author, string $login = '')
    {
        $this->text = $text;
        $this->createdAt = $createdAt;
        $this->author = $author;
        $this->login = $login;
        parent::__construct(0);
    }

    /**
     * @return string
     */
    public function getAuthorLogin(): string
    {
        return $this->getAuthor() ? $this->getAuthor()->getLogin() : '~' . $this->getLogin();
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
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text)
    {
        $this->text = $text;
    }

    /**
     * @return \d0niek\Whereiscash\Model\UserModel|null
     */
    public function getAuthor(): ?UserModel
    {
        return $this->author;
    }

    /**
     * @param \d0niek\Whereiscash\Model\UserModel|null $author
     */
    public function setAuthor(?UserModel $author)
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login)
    {
        $this->login = $login;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    //endregion Getters & Setters
}
