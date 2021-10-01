<?php

namespace ContainerVZ8mB0c;
include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/lib/Doctrine/Persistence/ObjectManager.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManagerInterface.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManager.php';

class EntityManager_9a5be93 extends \Doctrine\ORM\EntityManager implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager|null wrapped object, if the proxy is initialized
     */
    private $valueHolder91627 = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializera3b23 = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicPropertiesaad05 = [
        
    ];

    public function getConnection()
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'getConnection', array(), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->getConnection();
    }

    public function getMetadataFactory()
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'getMetadataFactory', array(), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->getMetadataFactory();
    }

    public function getExpressionBuilder()
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'getExpressionBuilder', array(), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->getExpressionBuilder();
    }

    public function beginTransaction()
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'beginTransaction', array(), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->beginTransaction();
    }

    public function getCache()
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'getCache', array(), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->getCache();
    }

    public function transactional($func)
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'transactional', array('func' => $func), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->transactional($func);
    }

    public function commit()
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'commit', array(), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->commit();
    }

    public function rollback()
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'rollback', array(), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->rollback();
    }

    public function getClassMetadata($className)
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'getClassMetadata', array('className' => $className), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->getClassMetadata($className);
    }

    public function createQuery($dql = '')
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'createQuery', array('dql' => $dql), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->createQuery($dql);
    }

    public function createNamedQuery($name)
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'createNamedQuery', array('name' => $name), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->createNamedQuery($name);
    }

    public function createNativeQuery($sql, \Doctrine\ORM\Query\ResultSetMapping $rsm)
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'createNativeQuery', array('sql' => $sql, 'rsm' => $rsm), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->createNativeQuery($sql, $rsm);
    }

    public function createNamedNativeQuery($name)
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'createNamedNativeQuery', array('name' => $name), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->createNamedNativeQuery($name);
    }

    public function createQueryBuilder()
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'createQueryBuilder', array(), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->createQueryBuilder();
    }

    public function flush($entity = null)
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'flush', array('entity' => $entity), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->flush($entity);
    }

    public function find($className, $id, $lockMode = null, $lockVersion = null)
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'find', array('className' => $className, 'id' => $id, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->find($className, $id, $lockMode, $lockVersion);
    }

    public function getReference($entityName, $id)
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'getReference', array('entityName' => $entityName, 'id' => $id), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->getReference($entityName, $id);
    }

    public function getPartialReference($entityName, $identifier)
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'getPartialReference', array('entityName' => $entityName, 'identifier' => $identifier), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->getPartialReference($entityName, $identifier);
    }

    public function clear($entityName = null)
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'clear', array('entityName' => $entityName), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->clear($entityName);
    }

    public function close()
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'close', array(), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->close();
    }

    public function persist($entity)
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'persist', array('entity' => $entity), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->persist($entity);
    }

    public function remove($entity)
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'remove', array('entity' => $entity), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->remove($entity);
    }

    public function refresh($entity)
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'refresh', array('entity' => $entity), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->refresh($entity);
    }

    public function detach($entity)
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'detach', array('entity' => $entity), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->detach($entity);
    }

    public function merge($entity)
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'merge', array('entity' => $entity), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->merge($entity);
    }

    public function copy($entity, $deep = false)
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'copy', array('entity' => $entity, 'deep' => $deep), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->copy($entity, $deep);
    }

    public function lock($entity, $lockMode, $lockVersion = null)
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'lock', array('entity' => $entity, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->lock($entity, $lockMode, $lockVersion);
    }

    public function getRepository($entityName)
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'getRepository', array('entityName' => $entityName), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->getRepository($entityName);
    }

    public function contains($entity)
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'contains', array('entity' => $entity), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->contains($entity);
    }

    public function getEventManager()
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'getEventManager', array(), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->getEventManager();
    }

    public function getConfiguration()
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'getConfiguration', array(), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->getConfiguration();
    }

    public function isOpen()
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'isOpen', array(), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->isOpen();
    }

    public function getUnitOfWork()
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'getUnitOfWork', array(), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->getUnitOfWork();
    }

    public function getHydrator($hydrationMode)
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'getHydrator', array('hydrationMode' => $hydrationMode), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->getHydrator($hydrationMode);
    }

    public function newHydrator($hydrationMode)
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'newHydrator', array('hydrationMode' => $hydrationMode), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->newHydrator($hydrationMode);
    }

    public function getProxyFactory()
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'getProxyFactory', array(), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->getProxyFactory();
    }

    public function initializeObject($obj)
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'initializeObject', array('obj' => $obj), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->initializeObject($obj);
    }

    public function getFilters()
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'getFilters', array(), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->getFilters();
    }

    public function isFiltersStateClean()
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'isFiltersStateClean', array(), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->isFiltersStateClean();
    }

    public function hasFilters()
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'hasFilters', array(), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return $this->valueHolder91627->hasFilters();
    }

    /**
     * Constructor for lazy initialization
     *
     * @param \Closure|null $initializer
     */
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;

        $reflection = $reflection ?? new \ReflectionClass(__CLASS__);
        $instance   = $reflection->newInstanceWithoutConstructor();

        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $instance, 'Doctrine\\ORM\\EntityManager')->__invoke($instance);

        $instance->initializera3b23 = $initializer;

        return $instance;
    }

    protected function __construct(\Doctrine\DBAL\Connection $conn, \Doctrine\ORM\Configuration $config, \Doctrine\Common\EventManager $eventManager)
    {
        static $reflection;

        if (! $this->valueHolder91627) {
            $reflection = $reflection ?? new \ReflectionClass('Doctrine\\ORM\\EntityManager');
            $this->valueHolder91627 = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);

        }

        $this->valueHolder91627->__construct($conn, $config, $eventManager);
    }

    public function & __get($name)
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, '__get', ['name' => $name], $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        if (isset(self::$publicPropertiesaad05[$name])) {
            return $this->valueHolder91627->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder91627;

            $backtrace = debug_backtrace(false, 1);
            trigger_error(
                sprintf(
                    'Undefined property: %s::$%s in %s on line %s',
                    $realInstanceReflection->getName(),
                    $name,
                    $backtrace[0]['file'],
                    $backtrace[0]['line']
                ),
                \E_USER_NOTICE
            );
            return $targetObject->$name;
        }

        $targetObject = $this->valueHolder91627;
        $accessor = function & () use ($targetObject, $name) {
            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __set($name, $value)
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, '__set', array('name' => $name, 'value' => $value), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder91627;

            $targetObject->$name = $value;

            return $targetObject->$name;
        }

        $targetObject = $this->valueHolder91627;
        $accessor = function & () use ($targetObject, $name, $value) {
            $targetObject->$name = $value;

            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __isset($name)
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, '__isset', array('name' => $name), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder91627;

            return isset($targetObject->$name);
        }

        $targetObject = $this->valueHolder91627;
        $accessor = function () use ($targetObject, $name) {
            return isset($targetObject->$name);
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = $accessor();

        return $returnValue;
    }

    public function __unset($name)
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, '__unset', array('name' => $name), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder91627;

            unset($targetObject->$name);

            return;
        }

        $targetObject = $this->valueHolder91627;
        $accessor = function () use ($targetObject, $name) {
            unset($targetObject->$name);

            return;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $accessor();
    }

    public function __clone()
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, '__clone', array(), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        $this->valueHolder91627 = clone $this->valueHolder91627;
    }

    public function __sleep()
    {
        $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, '__sleep', array(), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;

        return array('valueHolder91627');
    }

    public function __wakeup()
    {
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);
    }

    public function setProxyInitializer(\Closure $initializer = null) : void
    {
        $this->initializera3b23 = $initializer;
    }

    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializera3b23;
    }

    public function initializeProxy() : bool
    {
        return $this->initializera3b23 && ($this->initializera3b23->__invoke($valueHolder91627, $this, 'initializeProxy', array(), $this->initializera3b23) || 1) && $this->valueHolder91627 = $valueHolder91627;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolder91627;
    }

    public function getWrappedValueHolderValue()
    {
        return $this->valueHolder91627;
    }
}

if (!\class_exists('EntityManager_9a5be93', false)) {
    \class_alias(__NAMESPACE__.'\\EntityManager_9a5be93', 'EntityManager_9a5be93', false);
}
