<?php

namespace d0niek\Whereiscash\Core;

use d0niek\Whereiscash\Exception\RouterException;
use d0niek\Whereiscash\Model\Route;
use d0niek\Whereiscash\Model\RouteFactory;
use Ds\Map;
use Ds\Vector;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class Router implements RouterInterface
{
    /**
     * @var \Ds\Vector
     */
    private $routesConfig;

    /**
     * @var \d0niek\Whereiscash\Model\RouteFactory
     */
    private $routeFactory;

    /**
     * Router constructor.
     *
     * @param \Ds\Vector $routesConfig
     * @param \d0niek\Whereiscash\Model\RouteFactory $routeFactory
     */
    public function __construct(Vector $routesConfig, RouteFactory $routeFactory)
    {
        $this->routesConfig = $routesConfig;
        $this->routeFactory = $routeFactory;
    }

    public function findRoute(string $url): Route
    {
        foreach ($this->routesConfig as $routeConfig) {
            $requestUrl = explode('/', $url);
            $routeUrl = explode('/', $routeConfig->get('url'));

            if (!$this->compareUrlsLength($requestUrl, $routeUrl)) {
                continue;
            }

            $parameters = $this->getRouteParametersOrCompareConstants($requestUrl, $routeUrl);
            if ($parameters === null) {
                continue;
            }

            $route = $this->createRoute($url, $routeConfig->get('controller'), $parameters);

            return $route;
        }

        throw new RouterException('Route for url "' . $url . '" not found!');
    }

    /**
     * @param array $requestUrl
     * @param array $routeUrl
     *
     * @return bool
     */
    private function compareUrlsLength(array $requestUrl, array $routeUrl): bool
    {
        return count($requestUrl) === count($routeUrl);
    }

    /**
     * @param array $requestUrl
     * @param array $routeUrl
     *
     * @return \Ds\Map|null
     */
    private function getRouteParametersOrCompareConstants(array $requestUrl, array $routeUrl): ?Map
    {
        $parameters = new Map();

        for ($i = 0; $i < count($requestUrl); $i++) {
            if (preg_match('/\{(.+?)\}/', $routeUrl[$i], $parameter) === 1) {
                $parameters->put($parameter[1], $requestUrl[$i]);
            } elseif ($requestUrl[$i] !== $routeUrl[$i]) {
                return null;
            }
        }

        return $parameters;
    }

    /**
     * @param string $url
     * @param string $controller
     * @param \Ds\Map $parameters
     *
     * @return \d0niek\Whereiscash\Model\Route
     */
    private function createRoute(string $url, string $controller, Map $parameters): Route
    {
        $data = new Map(
            [
                'url' => $url,
                'controller' => $controller,
                'parameters' => $parameters,
            ]
        );
        /** @var \d0niek\Whereiscash\Model\Route $route */
        $route = $this->routeFactory->create($data);

        return $route;
    }
}
