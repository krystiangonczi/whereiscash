<?php

namespace d0niek\Whereiscash\Core;

use d0niek\Whereiscash\Controller\Controller;
use d0niek\Whereiscash\Exception\FrontControllerException;
use d0niek\Whereiscash\Model\Route;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class FrontController implements FrontControllerInterface
{
    /**
     * @var \d0niek\Whereiscash\Core\DependenceInjectionInterface
     */
    private $di;

    /**
     * @var string
     */
    private $controllerNamespace;

    /**
     * @var string
     */
    private $viewPath;

    /**
     * FrontController constructor.
     *
     * @param \d0niek\Whereiscash\Core\DependenceInjectionInterface $di
     * @param string $controllerNamespace
     * @param string $viewPath
     */
    public function __construct(
        DependenceInjectionInterface $di,
        string $controllerNamespace,
        string $viewPath
    ) {
        $this->di = $di;
        $this->controllerNamespace = $controllerNamespace;
        $this->viewPath = $viewPath;
    }

    public function getController(Route $route): Controller
    {
        $controllerClass = $this->getControllerClass($route->getController());
        $controller = new $controllerClass($this->di, $route, $this->viewPath);

        return $controller;
    }

    /**
     * @param string $controllerName
     *
     * @return string
     * @throws \d0niek\Whereiscash\Exception\FrontControllerException
     */
    protected function getControllerClass(string $controllerName): string
    {
        $controllerClass = str_replace(':', '\\', $controllerName);
        $controllerClass = $this->controllerNamespace . '\\' . $controllerClass;
        if (class_exists($controllerClass)) {
            return $controllerClass;
        }

        throw new FrontControllerException('Could not find controller "' . $controllerName . '"');
    }
}
