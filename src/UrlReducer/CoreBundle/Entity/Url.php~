<?php

namespace UrlReducer\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\Url()
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
    private $creation;

    /**
     * @var \Membre
     *
     * @ORM\ManyToOne(targetEntity="Membre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="auteur", referencedColumnName="id")
     * })
     */
    private $auteur;

    /**
     *
     */
    public function __construct() {
        $this->creation = new \DateTime();
    }

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
     * @param \UrlReducer\CoreBundle\Entity\Membre $auteur
     * @return Url
     */
    public function setAuteur(\UrlReducer\CoreBundle\Entity\Membre $auteur = null)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return \UrlReducer\CoreBundle\Entity\Membre
     */
    public function getAuteur()
    {
        return $this->auteur;
    }
}
