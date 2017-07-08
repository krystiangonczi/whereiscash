<?php

namespace d0niek\Whereiscash\Core;

use d0niek\Whereiscash\Exception\DependenceInjectionException;
use Ds\Map;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class DependenceInjection implements DependenceInjectionInterface
{
    /**
     * @var \d0niek\Whereiscash\Core\DependenceInjectionInterface
     */
    private static $instance = null;

    /**
     * @var \Ds\Map
     */
    private $services;

    /**
     * @var \Ds\Map
     */
    private $parameters;

    /**
     * DependenceInjection constructor.
     *
     * @param \Ds\Map|null $services
     * @param \Ds\Map|null $parameters
     */
    private function __construct(Map $services = null, Map $parameters = null)
    {
        $this->services = $services ?? new Map();
        $this->parameters = $parameters ?? new Map();
    }

    public static function getInstance(Map $services = null, Map $parameters = null): DependenceInjectionInterface
    {
        if (self::$instance === null) {
            self::$instance = new self($services, $parameters);
        }

        return self::$instance;
    }

    public function get(string $name)
    {
        if ($this->services->hasKey($name)) {
            return $this->services->get($name);
        }

        throw new DependenceInjectionException('Service "' . $name . '" is not defined');
    }

    public function has(string $name): bool
    {
        return $this->services->hasKey($name);
    }

    public function put(string $name, $value): void
    {
        if ($this->services->hasKey($name)) {
            throw new DependenceInjectionException('Service "' . $name . '" is defined');
        }

        $this->services->put($name, $value);
    }

    public function remove(string $name)
    {
        if ($this->services->hasKey($name)) {
            return $this->services->remove($name);
        }

        throw new DependenceInjectionException('Service "' . $name . '" does not exists');
    }

    public function getParam(string $name)
    {
        if ($this->parameters->hasKey($name)) {
            return $this->parameters->get($name);
        }

        throw new DependenceInjectionException('Parameter "' . $name . '" is not set');
    }

    public function hasParam(string $name): bool
    {
        return $this->parameters->hasKey($name);
    }

    public function putParam(string $name, $value): void
    {
        if ($this->parameters->hasKey($name)) {
            throw new DependenceInjectionException('Parameter "' . $name . '" is set');
        }

        $this->parameters->put($name, $value);
    }

    public function removeParam(string $name)
    {
        if ($this->parameters->hasKey($name)) {
            return $this->parameters->remove($name);
        }

        throw new DependenceInjectionException('Parameter "' . $name . '" does not exists');
    }
}
