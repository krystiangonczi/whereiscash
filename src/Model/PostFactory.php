<?php

namespace d0niek\Whereiscash\Model;

use Ds\Map;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class PostFactory extends ModelFactory
{
    public function create(Map $data): Model
    {
        $text = $data->get('text');
        $author = $data->get('author', null);
        $login = $data->get('login', '');
        $createdAt = $data->get('created_at', 'now');
        $createdAt = new \DateTime($createdAt);

        $post = new PostModel($text, $createdAt, $author, $login);

        return $post;
    }
}
