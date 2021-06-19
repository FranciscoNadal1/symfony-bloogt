<?php


namespace App\Tests;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;

class MockEntityManager implements EntityManagerInterface
{
    private $persistedObject = null;
    private $flushed = false;

    public function persist($object)
    {
        $this->persistedObject = $object;
    }

    public function flush()
    {
        $this->flushed = true;
    }

    public function isPersisted($object): bool
    {
        return $this->persistedObject === $object;
    }

    public function hasFlushed(): bool
    {
        return $this->flushed;
    }

    /** Defining all remaining EntityManager methods below */
    public function getCache() {}
    public function getConnection() {}
    public function getExpressionBuilder() {}
    public function beginTransaction() {}
    public function transactional($func) {}
    public function commit() {}
    public function rollback() {}
    public function createQuery($dql = '') {}
    public function createNamedQuery($name) {}
    public function createNativeQuery($sql, ResultSetMapping $rsm) {}
    public function createNamedNativeQuery($name) {}
    public function createQueryBuilder() {}
    public function getReference($entityName, $id) {}
    public function getPartialReference($entityName, $identifier) {}
    public function close() {}
    public function copy($entity, $deep = false) {}
    public function lock($entity, $lockMode, $lockVersion = null) {}
    public function getEventManager() {}
    public function getConfiguration() {}
    public function isOpen() {}
    public function getUnitOfWork() {}
    public function getHydrator($hydrationMode) {}
    public function newHydrator($hydrationMode) {}
    public function getProxyFactory() {}
    public function getFilters() {}
    public function isFiltersStateClean() {}
    public function hasFilters() {}
    public function find($className, $id) {}
    public function remove($object) {}
    public function merge($object) {}
    public function clear($objectName = null) {}
    public function detach($object) {}
    public function refresh($object) {}
    public function getRepository($className) {}
    public function getMetadataFactory() {}
    public function initializeObject($obj) {}
    public function contains($object) {}
    public function __call($name, $arguments) {}
    public function getClassMetadata($className) {}
}