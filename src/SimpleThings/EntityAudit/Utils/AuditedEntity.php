<?php

namespace SimpleThings\EntityAudit\Utils;


interface AuditedEntity
{
    public function setRevisionDate($revisionDate);

    public function getRevisionDate();
}