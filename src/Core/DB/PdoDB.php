<?php

namespace d0niek\Whereiscash\Core\DB;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class PdoDB implements DBInterface
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var \d0niek\Whereiscash\Core\DB\PdoDB
     */
    private static $instance = null;

    private function __construct(array $config)
    {
        $dns = $config['driver'] . ':dbname=' . $config['db_name'] . ';';
        $dns .= 'host=' . $config['host'] . ';port=' . $config['port'];
        $this->pdo = new \PDO($dns, $config['user'], $config['password']);
    }

    /**
     * @param array $dbConfig
     *
     * @return \d0niek\Whereiscash\Core\DB\DBInterface
     */
    public static function getInstance(array $dbConfig = []): DBInterface
    {
        if (self::$instance === null && !empty($dbConfig)) {
            self::$instance = new self($dbConfig);
        }

        return self::$instance;
    }

    /**
     * @return \PDO
     */
    public function getPdo(): \PDO
    {
        return $this->pdo;
    }
}
