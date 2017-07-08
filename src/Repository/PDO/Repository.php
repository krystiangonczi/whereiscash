<?php

namespace d0niek\Whereiscash\Repository\PDO;

use d0niek\Whereiscash\Core\DB\PdoDB;
use d0niek\Whereiscash\Core\RepositoryManagerInterface;
use d0niek\Whereiscash\Exception\ModelNotFoundException;
use d0niek\Whereiscash\Exception\RepositoryException;
use d0niek\Whereiscash\Model\Model;
use Ds\Vector;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
abstract class Repository
{
    private const CODE_OK = '00000';

    /**
     * @var \d0niek\Whereiscash\Core\RepositoryManagerInterface
     */
    protected $repositoryManager;

    /**
     * @var string
     */
    protected $model = 'model';

    /**
     * @var string
     */
    protected $table = 'table';

    /**
     * @var string
     */
    protected $idField = 'id';

    /**
     * @var string[]
     */
    protected $fields = [];

    /**
     * @var string[]
     */
    protected $insertFields = [];

    /**
     * Repository constructor.
     *
     * @param \d0niek\Whereiscash\Core\RepositoryManagerInterface $repositoryManager
     */
    public function __construct(RepositoryManagerInterface $repositoryManager)
    {
        $this->repositoryManager = $repositoryManager;
    }

    public function find($id): Model
    {
        return $this->findOneBy($this->idField, $id);
    }

    public function findOneBy(string $field, $value): Model
    {
        $models = $this->findBy($field, $value);
        if ($models->isEmpty()) {
            throw new ModelNotFoundException($this->model . ' with ' . $field .' = `' . $value . '` not found');
        }

        return $models->first();
    }

    public function findBy(string $field, $value): Vector
    {
        $sql = 'SELECT ' . implode(',', $this->fields) . ' FROM ' . $this->table . ' WHERE ' . $field . ' = ?';
        $models = $this->createModelsFromQuery($sql, [$value]);

        return $models;
    }

    public function findAll(int $limit = 0, int $offset = 0, string $orderBy = ''): Vector
    {
        $sql = 'SELECT ' . implode(',', $this->fields) . ' FROM ' . $this->table;

        if ($orderBy !== '') {
            $sql .= ' ORDER BY ' . $orderBy;
        }

        if ($limit > 0) {
            $sql .= ' LIMIT :limit OFFSET :offset';
        }

        $models = $this->createModelsFromQuery($sql, null, $limit, $offset);

        return $models;
    }

    /**
     * @param array $data
     *
     * @return \d0niek\Whereiscash\Model\Model
     */
    protected function saveData(array $data): Model
    {
        $sql = 'INSERT INTO ' . $this->table . ' (' . implode(',', $this->insertFields) . ') ';
        $sql .= 'VALUE (' . str_repeat('?,', count($this->insertFields) - 1) . '?)';
        $this->executeQuery($sql, $data);

        $modelId = (int)$this->getLastInsertId();
        $model = $this->find($modelId);

        return $model;
    }

    /**
     * @inheritDoc
     */
    public function remove(Model $model): Model
    {
        $sql = 'DELETE FROM ' . $this->table . ' WHERE ' . $this->idField . ' = ?';
        $this->executeQuery($sql, [$model->getId()]);

        return $model;
    }

    /**
     * @return string
     */
    protected function getLastInsertId(): string
    {
        $sql = 'SELECT MAX(' . $this->idField . ') AS last_id FROM ' . $this->table;
        $sth = $this->executeQuery($sql);
        $result = $sth->fetch(\PDO::FETCH_ASSOC);

        return $result['last_id'];
    }

    /**
     * @param string $query
     * @param array|null $values
     * @param int $limit
     * @param int $offset
     *
     * @return \PDOStatement
     * @throws \d0niek\Whereiscash\Exception\RepositoryException
     */
    protected function executeQuery(string $query, array $values = null, int $limit = 0, int $offset = 0): \PDOStatement
    {
        /** @var \PDO $pdo */
        $pdo = PdoDB::getInstance()->getPdo();
        $sth = $pdo->prepare($query);

        if ($limit > 0) {
            $sth->bindValue(':limit', $limit, \PDO::PARAM_INT);
            $sth->bindValue(':offset', $offset, \PDO::PARAM_INT);
        }

        $sth->execute($values);

        if ($sth->errorCode() !== self::CODE_OK) {
            $this->throwException($sth, $values, $limit, $offset);
        }

        return $sth;
    }

    /**
     * @param string $query
     * @param array $values
     * @param int $limit
     * @param int $offset
     *
     * @return \Ds\Vector
     */
    protected function createModelsFromQuery(
        string $query,
        array $values = null,
        int $limit = 0,
        int $offset = 0
    ): Vector {
        $users = new Vector();
        $sth = $this->executeQuery($query, $values, $limit, $offset);
        $results = $sth->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($results as $result) {
            $user = $this->createModel($result);
            $users->push($user);
        }

        return $users;
    }

    /**
     * @param array $dbData
     *
     * @return \d0niek\Whereiscash\Model\Model
     */
    abstract protected function createModel(array $dbData): Model;

    /**
     * @param \PDOStatement $sth
     * @param array|null $values
     * @param int $limit
     * @param int $offset
     *
     * @throws \d0niek\Whereiscash\Exception\RepositoryException
     */
    private function throwException(\PDOStatement $sth, ?array $values, int $limit = 0, int $offset = 0): void
    {
        if ($values === null) {
            $values = [];
        }

        $message = $sth->errorInfo()[2] . "\n";
        $message .= 'Query: ' . $sth->queryString . "\n";
        $message .= "Values:\n";
        $valueIndex = 0;
        foreach ($values as $no => $value) {
            $message .= ($no + 1) . '. ' . gettype($value) . ' (' . $value . ")\n";
            $valueIndex = $no;
        }

        if ($limit > 0) {
            $message .= $valueIndex + 2 . '. ' . gettype($limit) . ' (' . $limit . ")\n";
            $message .= $valueIndex + 3 . '. ' . gettype($offset) . ' (' . $offset . ")\n";
        }

        throw new RepositoryException($message);
    }
}
