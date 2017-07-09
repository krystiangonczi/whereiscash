<?php

namespace d0niek\Whereiscash\Controller;

use d0niek\Whereiscash\Http\ResponseInterface;
use Ds\Map;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class DefaultController extends Controller
{
    public function execute(): ResponseInterface
    {
        $user = $this->get('user');

        return $this->render(
            'default',
            new Map([
                'user' => $user
            ])
        );
    }
}
