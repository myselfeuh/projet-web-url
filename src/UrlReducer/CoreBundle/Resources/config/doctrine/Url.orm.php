<?php

use Doctrine\ORM\Mapping\ClassMetadataInfo;

$metadata->setInheritanceType(ClassMetadataInfo::INHERITANCE_TYPE_NONE);
$metadata->customRepositoryClassName = 'UrlReducer\CoreBundle\Entity\UrlRepository';
$metadata->setChangeTrackingPolicy(ClassMetadataInfo::CHANGETRACKING_DEFERRED_IMPLICIT);
$metadata->mapField(array(
   'fieldName' => 'id',
   'type' => 'integer',
   'id' => true,
   'columnName' => 'id',
  ));
$metadata->mapField(array(
   'columnName' => 'source',
   'fieldName' => 'source',
   'type' => 'string',
   'length' => '1024',
  ));
$metadata->mapField(array(
   'columnName' => 'courte',
   'fieldName' => 'courte',
   'type' => 'string',
   'length' => '10',
  ));
$metadata->mapField(array(
   'columnName' => 'creation',
   'fieldName' => 'creation',
   'type' => 'time',
  ));
$metadata->mapField(array(
   'columnName' => 'auteur',
   'fieldName' => 'auteur',
   'type' => 'integer',
  ));
$metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_AUTO);