<?php

namespace d0niek\Whereiscash\Http;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
interface ResponseInterface
{
    /**
     * @return string
     */
    public function getHtml(): string;
}
