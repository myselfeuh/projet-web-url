<?php

use Doctrine\ORM\Mapping\ClassMetadataInfo;

$metadata->setInheritanceType(ClassMetadataInfo::INHERITANCE_TYPE_NONE);
$metadata->customRepositoryClassName = 'UrlReducer\CoreBundle\Entity\MemberRepository';
$metadata->setChangeTrackingPolicy(ClassMetadataInfo::CHANGETRACKING_DEFERRED_IMPLICIT);
$metadata->mapField(array(
   'fieldName' => 'id',
   'type' => 'integer',
   'id' => true,
   'columnName' => 'id',
  ));
$metadata->mapField(array(
   'columnName' => 'nom',
   'fieldName' => 'nom',
   'type' => 'string',
   'length' => '64',
  ));
$metadata->mapField(array(
   'columnName' => 'prenom',
   'fieldName' => 'prenom',
   'type' => 'string',
   'length' => '64',
  ));
$metadata->mapField(array(
   'columnName' => 'pseudo',
   'fieldName' => 'pseudo',
   'type' => 'string',
   'length' => '64',
  ));
$metadata->mapField(array(
   'columnName' => 'mail',
   'fieldName' => 'mail',
   'type' => 'string',
   'length' => '64',
  ));
$metadata->mapField(array(
   'columnName' => 'mdp',
   'fieldName' => 'mdp',
   'type' => 'string',
   'length' => '40',
  ));
$metadata->mapField(array(
   'columnName' => 'activation',
   'fieldName' => 'activation',
   'type' => 'string',
   'length' => '40',
  ));
$metadata->mapField(array(
   'columnName' => 'profil',
   'fieldName' => 'profil',
   'type' => 'string',
   'length' => '16',
  ));
$metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_AUTO);