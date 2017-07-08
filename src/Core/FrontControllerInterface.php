<?php

namespace d0niek\Whereiscash\Core;

use d0niek\Whereiscash\Controller\Controller;
use d0niek\Whereiscash\Model\Route;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
interface FrontControllerInterface
{
    /**
     * @param \d0niek\Whereiscash\Model\Route $route
     *
     * @return \d0niek\Whereiscash\Controller\Controller
     * @throws \d0niek\Whereiscash\Exception\FrontControllerException
     */
    public function getController(Route $route): Controller;
}
