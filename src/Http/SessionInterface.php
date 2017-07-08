<?php

namespace d0niek\Whereiscash\Http;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
interface SessionInterface
{
    /**
     * @return \d0niek\Whereiscash\Http\SessionInterface
     */
    public static function getInstance(): SessionInterface;

    /**
     * @return bool
     */
    public function startSession(): bool;

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get(string $key);

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * @param string $key
     * @param $value
     */
    public function put(string $key, $value): void;

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function remove(string $key);

    /**
     * @return bool
     */
    public function destroy(): bool;
}
