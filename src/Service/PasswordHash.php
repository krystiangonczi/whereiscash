<?php

namespace d0niek\Whereiscash\Service;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class PasswordHash implements PasswordHashInterface
{
    /**
     * @var string
     */
    private $salt;

    /**
     * @var int
     */
    private $cost;

    /**
     * PasswordHash constructor.
     *
     * @param string $salt
     * @param int $cost
     */
    public function __construct(string $salt, int $cost)
    {
        $this->salt = $salt;
        $this->cost = $cost;
    }

    public function hash(string $password): string
    {
        $options = [
            'cost' => $this->cost,
            'salt' => $this->salt,
        ];
        $passwordHash = password_hash($password, PASSWORD_BCRYPT, $options);

        return $passwordHash;
    }
}
