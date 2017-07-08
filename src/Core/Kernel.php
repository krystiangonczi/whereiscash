<?php

namespace d0niek\Whereiscash\Core;

use d0niek\Whereiscash\Http\Response\RedirectResponse;
use d0niek\Whereiscash\Http\RequestInterface;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class Kernel
{
    /**
     * @var \d0niek\Whereiscash\Http\RequestInterface
     */
    private $request;

    /**
     * @var \d0niek\Whereiscash\Core\RouterInterface
     */
    private $router;

    /**
     * @var \d0niek\Whereiscash\Core\FrontControllerInterface
     */
    private $frontController;

    /**
     * Kernel constructor.
     *
     * @param \d0niek\Whereiscash\Http\RequestInterface $request
     * @param \d0niek\Whereiscash\Core\RouterInterface $router
     * @param \d0niek\Whereiscash\Core\FrontControllerInterface $frontController
     */
    public function __construct(
        RequestInterface $request,
        RouterInterface $router,
        FrontControllerInterface $frontController
    ) {
        $this->request = $request;
        $this->router = $router;
        $this->frontController = $frontController;
    }

    public function start(): void
    {
        $url = $this->request->getPath();
        $route = $this->router->findRoute($url);
        $controller = $this->frontController->getController($route);
        $response = $controller->execute();
        if ($response instanceof RedirectResponse) {
            header('Location:' . $response->getHtml());
            return;
        }
        echo $response->getHtml();
    }
}
