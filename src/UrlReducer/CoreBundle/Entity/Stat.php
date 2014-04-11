<?php

namespace UrlReducer\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stat
 *
 * @ORM\Table(name="utilisations", indexes={@ORM\Index(name="url", columns={"url"})})
 * @ORM\Entity
 */
class Stat
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date = 'CURRENT_TIMESTAMP';

    /**
     * @var \Urls
     *
     * @ORM\ManyToOne(targetEntity="Urls")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="url", referencedColumnName="id")
     * })
     */
    private $url;


}
