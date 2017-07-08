<?php

namespace d0niek\Whereiscash\Http\Response;

use d0niek\Whereiscash\Http\ResponseInterface;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class RedirectResponse implements ResponseInterface
{
    /**
     * @var string
     */
    private $redirectUrl;

    /**
     * RedirectResponse constructor.
     *
     * @param string $redirectUrl
     */
    public function __construct(string $redirectUrl = '/')
    {
        $this->redirectUrl = $redirectUrl;
    }

    public function getHtml(): string
    {
        return $this->redirectUrl;
    }

    //region Getters & Setters

    /**
     * @return string
     */
    public function getRedirectUrl(): string
    {
        return $this->redirectUrl;
    }

    /**
     * @param string $redirectUrl
     */
    public function setRedirectUrl(string $redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }

    //endregion Getters & Setters
}
