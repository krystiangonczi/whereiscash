<?php

namespace d0niek\Whereiscash\Controller;

use d0niek\Whereiscash\Core\DependenceInjectionInterface;
use d0niek\Whereiscash\Http\Response\HtmlResponse;
use d0niek\Whereiscash\Http\Response\RedirectResponse;
use d0niek\Whereiscash\Http\ResponseInterface;
use d0niek\Whereiscash\Model\Route;
use Ds\Map;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
abstract class Controller
{
    /**
     * @var \d0niek\Whereiscash\Http\RequestInterface
     */
    protected $request;

    /**
     * @var \d0niek\Whereiscash\Http\SessionInterface
     */
    protected $session;

    /**
     * @var \d0niek\Whereiscash\Model\Route
     */
    protected $route;

    /**
     * @var \d0niek\Whereiscash\Core\DependenceInjectionInterface
     */
    private $di;

    /**
     * @var string
     */
    private $viewPath;

    /**
     * Controller constructor.
     *
     * @param \d0niek\Whereiscash\Core\DependenceInjectionInterface $di
     * @param \d0niek\Whereiscash\Model\Route $route
     * @param string $viewPath
     */
    public function __construct(
        DependenceInjectionInterface $di,
        Route $route,
        string $viewPath
    ) {
        $this->di = $di;
        $this->route = $route;
        $this->viewPath = $viewPath;

        $this->request = $this->di->get('request');
        $this->session = $this->di->get('session');
    }

    /**
     * @return \d0niek\Whereiscash\Http\ResponseInterface
     */
    abstract public function execute(): ResponseInterface;

    /**
     * @param string $template
     * @param \Ds\Map $parameters
     *
     * @return \d0niek\Whereiscash\Http\Response\HtmlResponse
     */
    protected function render(string $template, Map $parameters = null): HtmlResponse
    {
        if ($parameters === null) {
            $parameters = new Map();
        }

        $parameters->put('user', $this->di->get('user'));

        return new HtmlResponse($this->viewPath, $template, $parameters, $this->session);
    }

    /**
     * @param string $redirectUrl
     *
     * @return \d0niek\Whereiscash\Http\Response\RedirectResponse
     */
    protected function redirect(string $redirectUrl): RedirectResponse
    {
        return new RedirectResponse($redirectUrl);
    }

    /**
     * @param string $serviceName
     *
     * @return mixed
     */
    protected function get(string $serviceName)
    {
        return $this->di->get($serviceName);
    }
}
