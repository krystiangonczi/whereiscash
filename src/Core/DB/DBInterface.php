<?php

namespace d0niek\Whereiscash\Core\DB;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
interface DBInterface
{
    /**
     * @param array $dbConfig
     *
     * @return \d0niek\Whereiscash\Core\DB\DBInterface
     */
    public static function getInstance(array $dbConfig): DBInterface;
}
