<?php

namespace d0niek\Whereiscash\Core;

use d0niek\Whereiscash\Repository\RepositoryInterface;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
interface RepositoryManagerInterface
{
    /**
     * @param string $name
     *
     * @return \d0niek\Whereiscash\Repository\RepositoryInterface
     * @throws \d0niek\Whereiscash\Exception\RepositoryException
     */
    public function getRepository(string $name): RepositoryInterface;
}
