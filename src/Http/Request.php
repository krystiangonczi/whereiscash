<?php

namespace d0niek\Whereiscash\Http;

use Ds\Map;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class Request implements RequestInterface
{
    /**
     * @var \Ds\Map
     */
    private $server;

    /**
     * @var \Ds\Map
     */
    private $queryMap;

    /**
     * @var \Ds\Map
     */
    private $postMap;

    /**
     * @var string
     */
    private $path;

    /**
     * Request constructor.
     *
     * @param array $server
     * @param array $query
     * @param array $post
     */
    public function __construct(array $server, array $query, array $post)
    {
        $this->server = new Map($server);
        $this->queryMap = new Map($query);
        $this->postMap = new Map($post);

        $this->path = '';
    }

    public function getHost(): string
    {
        return $this->server->get('HTTP_HOST');
    }

    public function getPath(): string
    {
        if ($this->path === '') {
            $requestUriArray = explode('?', $this->server->get('REQUEST_URI'), 2);
            $this->path = array_shift($requestUriArray);
        }
        return $this->path;
    }

    public function getMethod(): string
    {
        return $this->server->get('REQUEST_METHOD');
    }

    public function get(string $name, string $default = null): string
    {
        if (func_num_args() === 2) {
            return $this->queryMap->get($name, $default);
        }

        return $this->queryMap->get($name);
    }

    public function post(string $name, string $default = null): string
    {
        if (func_num_args() === 2) {
            return $this->postMap->get($name, $default);
        }

        return $this->postMap->get($name);
    }

    public function isPost(): bool
    {
        return $this->getMethod() === 'POST';
    }
}
