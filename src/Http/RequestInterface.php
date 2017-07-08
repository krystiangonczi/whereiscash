<?php

namespace d0niek\Whereiscash\Http;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
interface RequestInterface
{
    /**
     * @return string
     */
    public function getHost(): string;

    /**
     * @return string
     */
    public function getPath(): string;

    /**
     * @return string
     */
    public function getMethod(): string;

    /**
     * @param string $name
     * @param string|null $default
     *
     * @return string
     */
    public function get(string $name, string $default = null): string;

    /**
     * @param string $name
     * @param string|null $default
     *
     * @return string
     */
    public function post(string $name, string $default = null): string;

    /**
     * @return bool
     */
    public function isPost(): bool;
}
