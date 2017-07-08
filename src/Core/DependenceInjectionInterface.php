<?php

namespace d0niek\Whereiscash\Core;

use Ds\Map;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
interface DependenceInjectionInterface
{
    /**
     * @param \Ds\Map|null $services
     * @param \Ds\Map|null $parameters
     *
     * @return \d0niek\Whereiscash\Core\DependenceInjectionInterface
     */
    public static function getInstance(Map $services = null, Map $parameters = null): DependenceInjectionInterface;

    /**
     * @param string $name
     *
     * @return mixed
     * @throws \d0niek\Whereiscash\Exception\DependenceInjectionException
     */
    public function get(string $name);

    /**
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name): bool;

    /**
     * @param string $name
     * @param $value
     *
     * @throws \d0niek\Whereiscash\Exception\DependenceInjectionException
     */
    public function put(string $name, $value): void;

    /**
     * @param string $name
     *
     * @return mixed
     * @throws \d0niek\Whereiscash\Exception\DependenceInjectionException
     */
    public function remove(string $name);

    /**
     * @param string $name
     *
     * @return mixed
     * @throws \d0niek\Whereiscash\Exception\DependenceInjectionException
     */
    public function getParam(string $name);

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasParam(string $name): bool;

    /**
     * @param string $name
     * @param $value
     *
     * @throws \d0niek\Whereiscash\Exception\DependenceInjectionException
     */
    public function putParam(string $name, $value): void;

    /**
     * @param string $name
     *
     * @return mixed
     * @throws \d0niek\Whereiscash\Exception\DependenceInjectionException
     */
    public function removeParam(string $name);
}
