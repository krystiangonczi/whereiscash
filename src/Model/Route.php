<?php

namespace d0niek\Whereiscash\Model;

use Ds\Map;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class Route extends Model
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $controller;

    /**
     * @var \Ds\Map
     */
    private $parameters;

    /**
     * Route constructor.
     *
     * @param string $url
     * @param string $controller
     * @param \Ds\Map $parameters
     */
    public function __construct(string $url, string $controller, Map $parameters)
    {
        $this->url = $url;
        $this->controller = $controller;
        $this->parameters = $parameters;
    }

    //region Getters

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @param string $name
     * @param string $default
     *
     * @return string
     */
    public function getParam(string $name, string $default = null): string
    {
        if (func_num_args() === 2) {
            return $this->parameters->get($name, $default);
        }

        return $this->parameters->get($name);
    }

    //endregion Getters
}
