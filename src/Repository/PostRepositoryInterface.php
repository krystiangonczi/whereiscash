<?php

namespace d0niek\Whereiscash\Repository;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
interface PostRepositoryInterface extends RepositoryInterface
{
    /**
     * @return int
     */
    public function countPost(): int;
}
