<?php

namespace UrlReducer\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Url
 *
 * @ORM\Table(name="urls", uniqueConstraints={@ORM\UniqueConstraint(name="courte", columns={"courte"})}, indexes={@ORM\Index(name="auteur", columns={"auteur"})})
 * @ORM\Entity
 */
class Url
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="source", type="string", length=1024, nullable=false)
     */
    private $source;

    /**
     * @var string
     *
     * @ORM\Column(name="courte", type="string", length=10, nullable=false)
     */
    private $courte;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation", type="datetime", nullable=false)
     */
    private $creation = 'CURRENT_TIMESTAMP';

    /**
     * @var \Membres
     *
     * @ORM\ManyToOne(targetEntity="Membres")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="auteur", referencedColumnName="id")
     * })
     */
    private $auteur;


}
