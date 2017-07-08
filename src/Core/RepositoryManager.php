<?php

namespace d0niek\Whereiscash\Core;

use d0niek\Whereiscash\Exception\RepositoryManagerException;
use d0niek\Whereiscash\Repository\RepositoryInterface;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class RepositoryManager implements RepositoryManagerInterface
{
    /**
     * @var string
     */
    private $repositoryNamespace;

    /**
     * @var string
     */
    private $modelNamespace;

    /**
     * RepositoryManager constructor.
     *
     * @param string $repositoryNamespace
     * @param string $modelNamespace
     */
    public function __construct(string $repositoryNamespace, string $modelNamespace)
    {
        $this->repositoryNamespace = $repositoryNamespace;
        $this->modelNamespace = $modelNamespace;
    }

    public function getRepository(string $repositoryName): RepositoryInterface
    {
        $repositoryClass = $this->getRepositoryClass($repositoryName);
        $repository = new $repositoryClass($this);

        return $repository;
    }

    /**
     * @param string $repositoryName
     *
     * @return string
     * @throws \d0niek\Whereiscash\Exception\RepositoryManagerException
     */
    protected function getRepositoryClass(string $repositoryName): string
    {
        $repositoryClass = str_replace(':', '\\', $repositoryName);
        $repositoryClass = $this->repositoryNamespace . '\\' . $repositoryClass . 'Repository';
        if (class_exists($repositoryClass)) {
            return $repositoryClass;
        }

        throw new RepositoryManagerException('Could not find repository "' . $repositoryName . '"');
    }
}
