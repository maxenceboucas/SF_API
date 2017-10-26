<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Account_Follower;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * Account
 *
 * @ORM\Table(name="account",
 *      uniqueConstraints={@ORM\UniqueConstraint(name="accounts_id_insta_unique",columns={"id_insta"})}
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AccountRepository")
 */
class Account
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="id_insta", type="string", length=255, unique=true)
     */
    private $idInsta;

    /**
     * @ORM\OneToMany(targetEntity="Account_Follower", mappedBy="account")
     * @var Account_Follower[]
     */
    protected $followers;

    /**
     * @ORM\OneToMany(targetEntity="Account_Follower", mappedBy="follower")
     * @var Account_Follower[]
     */
    protected $followeds;

    public function __construct()
    {
        $this->followers = new ArrayCollection();
        $this->followeds = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idInsta
     *
     * @param string $idInsta
     *
     * @return Account
     */
    public function setIdInsta($idInsta)
    {
        $this->idInsta = $idInsta;

        return $this;
    }

    /**
     * Get idInsta
     *
     * @return string
     */
    public function getIdInsta()
    {
        return $this->idInsta;
    }
}
