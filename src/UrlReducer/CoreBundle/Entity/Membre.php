<?php

namespace UrlReducer\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Membre
 *
 * @ORM\Table(name="membres", uniqueConstraints={@ORM\UniqueConstraint(name="pseudo", columns={"pseudo"})})
 * @ORM\Entity
 */
class Membre
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
     * @ORM\Column(name="nom", type="string", length=64, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=64, nullable=false)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="pseudo", type="string", length=64, nullable=false)
     */
    private $pseudo;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=64, nullable=false)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="mdp", type="string", length=40, nullable=false)
     */
    private $mdp;

    /**
     * @var string
     *
     * @ORM\Column(name="activation", type="string", length=40, nullable=false)
     */
    private $activation;

    /**
     * @var string
     *
     * @ORM\Column(name="profil", type="string", length=16, nullable=false)
     */
    private $profil;


}
