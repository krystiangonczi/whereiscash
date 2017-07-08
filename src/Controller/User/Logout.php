<?php

namespace d0niek\Whereiscash\Controller\User;

use d0niek\Whereiscash\Controller\Controller;
use d0niek\Whereiscash\Http\ResponseInterface;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class Logout extends Controller
{
    public function execute(): ResponseInterface
    {
        if ($this->session->has('user')) {
            $this->session->remove('user');
        }

        return $this->redirect('/');
    }
}
