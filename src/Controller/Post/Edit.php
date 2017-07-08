<?php

namespace d0niek\Whereiscash\Controller\Post;

use d0niek\Whereiscash\Controller\Controller;
use d0niek\Whereiscash\Http\ResponseInterface;
use Ds\Map;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class Edit extends Controller
{
    public function execute(): ResponseInterface
    {
        $postId = $this->route->getParam('id');

        return $this->render(
            'post:edit',
            new Map([
                'postId' => $postId,
            ])
        );
    }
}
