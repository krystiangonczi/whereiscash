<?php

namespace d0niek\Whereiscash\Model;

use Ds\Map;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class RouteFactory extends ModelFactory
{
    public function create(Map $data): Model
    {
        $url = $data->get('url');
        $controller = $data->get('controller');
        $parameters = $data->get('parameters');

        $route = new Route($url, $controller, $parameters);

        return $route;
    }
}
