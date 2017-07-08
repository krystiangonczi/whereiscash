<?php

namespace d0niek\Whereiscash\Controller;

use d0niek\Whereiscash\Http\ResponseInterface;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class DefaultController extends Controller
{
    public function execute(): ResponseInterface
    {
        return $this->render(
            'default'
        );
    }
}
