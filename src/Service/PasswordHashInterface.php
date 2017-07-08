<?php

namespace d0niek\Whereiscash\Service;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
interface PasswordHashInterface
{
    /**
     * @param string $password
     *
     * @return string
     */
    public function hash(string $password): string;
}
