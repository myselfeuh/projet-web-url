<?php

namespace UrlReducer\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @Entity
 * @Table(name="urls")
 */
class Url
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $source;

    /**
     * @var string
     */
    private $courte;

    /**
     * @var \DateTime
     */
    private $creation;

    /**
     * @var integer
     */
    private $auteur;


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
     * Set source
     *
     * @param string $source
     * @return Url
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string 
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set courte
     *
     * @param string $courte
     * @return Url
     */
    public function setCourte($courte)
    {
        $this->courte = $courte;

        return $this;
    }

    /**
     * Get courte
     *
     * @return string 
     */
    public function getCourte()
    {
        return $this->courte;
    }

    /**
     * Set creation
     *
     * @param \DateTime $creation
     * @return Url
     */
    public function setCreation($creation)
    {
        $this->creation = $creation;

        return $this;
    }

    /**
     * Get creation
     *
     * @return \DateTime 
     */
    public function getCreation()
    {
        return $this->creation;
    }

    /**
     * Set auteur
     *
     * @param integer $auteur
     * @return Url
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return integer 
     */
    public function getAuteur()
    {
        return $this->auteur;
    }
}
