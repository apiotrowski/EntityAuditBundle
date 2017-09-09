<?php

namespace SimpleThings\EntityAudit\Collection;

use SimpleThings\EntityAudit\AuditReader;

/**
 * @todo: WIP, implement Collection interface
 */
class AuditedManyToManyCollection
{
    /**
     * Related audit reader instance
     *
     * @var AuditReader
     */
    protected $auditReader;

    /**
     * Class to fetch
     * @var string
     */
    protected $class;

    /**
     * Maximum revision to fetch
     * @var string
     */
    protected $revision;

    /**
     * @var bool
     */
    protected $initialized;

    /**
     * @var array
     */
    protected $entities;

    /**
     * @var string
     */
    private $auditedManyToManyTable;

    /**
     * @var string
     */
    private $ownerIdValue;

    /**
     * @var string
     */
    private $ownerIdField;

    /**
     * @var string
     */
    private $targetIdField;

    /**
     * @param AuditReader $auditReader
     * @param string $joinTable
     * @param string $targetClass
     * @param string $ownerIdField
     * @param string $ownerIdValue
     * @param string $targetIdField
     * @param integer $revision
     */
    public function __construct(AuditReader $auditReader, $joinTable, $targetClass, $ownerIdField, $ownerIdValue, $targetIdField, $revision)
    {
        $this->auditReader = $auditReader;
        $this->auditedManyToManyTable = $joinTable;
        $this->class = $targetClass;
        $this->ownerIdField = $ownerIdField;
        $this->ownerIdValue = $ownerIdValue;
        $this->targetIdField = $targetIdField;
        $this->revision = $revision;
        $this->initialized = false;
        $this->entities = [];
    }

    /**
     * {@inheritdoc}
     */
    public function getValues()
    {
        $this->forceLoad();

        return array_values($this->entities);
    }

    protected function resolve($entity)
    {
        return $this->auditReader
            ->find(
                $this->class,
                $entity['keys'],
                $this->revision
            );
    }

    protected function forceLoad()
    {
        $this->initialize();

        foreach ($this->entities as $key => $entity) {
            if (is_array($entity)) {
                $this->entities[$key] = $this->resolve($entity);
            }
        }
    }

    private function initialize()
    {
        $sql = 'SELECT mtm.' . $this->targetIdField . ' FROM ' . $this->auditedManyToManyTable . ' AS mtm
        WHERE mtm.' . $this->ownerIdField . ' = ? AND mtm.revtype <> ? AND mtm.' . $this->auditReader->getConfiguration()->getRevisionFieldName() . ' = ?';

        $rows = $this->auditReader->getConnection()->executeQuery($sql, [$this->ownerIdValue, 'DEL', $this->revision]);

        $this->entities = [];
        foreach ($rows as $row) {
            $entity['keys'] = [
                'id' => $row[$this->targetIdField],
            ];
            $this->entities[] = $entity;
        }

        $this->initialized = true;
    }
}