<?php

namespace d0niek\Whereiscash\Core;

use d0niek\Whereiscash\Model\Route;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
interface RouterInterface
{
    /**
     * @param string $url
     *
     * @return \d0niek\Whereiscash\Model\Route
     * @throws \d0niek\Whereiscash\Exception\RouterException
     */
    public function findRoute(string $url): Route;
}
