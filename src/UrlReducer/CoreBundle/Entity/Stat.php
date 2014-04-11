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



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Stat
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set url
     *
     * @param \UrlReducer\CoreBundle\Entity\Urls $url
     * @return Stat
     */
    public function setUrl(\UrlReducer\CoreBundle\Entity\Urls $url = null)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return \UrlReducer\CoreBundle\Entity\Urls 
     */
    public function getUrl()
    {
        return $this->url;
    }
}
