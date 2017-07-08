<?php

namespace d0niek\Whereiscash\Http;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class Session implements SessionInterface
{
    public const SESSION_STARTED = true;
    public const SESSION_NOT_STARTED = false;

    /**
     * @var bool
     */
    private $sessionState = self::SESSION_NOT_STARTED;

    /**
     * @var \d0niek\Whereiscash\Http\SessionInterface|null
     */
    private static $instance = null;

    /**
     * Session constructor.
     */
    private function __construct()
    {
    }

    public static function getInstance(): SessionInterface
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        self::$instance->startSession();

        return self::$instance;
    }

    public function startSession(): bool
    {
        if ($this->sessionState === self::SESSION_NOT_STARTED) {
            $this->sessionState = session_start();
        }

        return $this->sessionState;
    }

    public function get(string $key)
    {
        return $_SESSION[$key];
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $_SESSION);
    }

    public function put(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function remove(string $key)
    {
        unset($_SESSION[$key]);
    }

    public function destroy(): bool
    {
        if ($this->sessionState === self::SESSION_STARTED) {
            $this->sessionState = !session_destroy();
            unset($_SESSION);

            return !$this->sessionState;
        }

        return false;
    }
}
