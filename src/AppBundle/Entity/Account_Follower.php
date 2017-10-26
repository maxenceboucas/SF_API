<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Account_Follower
 *
 * @ORM\Table(name="account__follower")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Account_FollowerRepository")
 */
class Account_Follower
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
     * create datetime.
     *
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * true = follow , false = unfollow.
     *
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    protected $action;

    /**
     * @ORM\ManyToOne(targetEntity="Account", inversedBy="followers")
     * @var Account
     */
    protected $account;

    /**
     * @ORM\ManyToOne(targetEntity="Account", inversedBy="followeds")
     * @var Account
     */
    protected $follower;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Account_Follower
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set action
     *
     * @param boolean $action
     *
     * @return Account_Follower
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return boolean
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set account
     *
     * @param \AppBundle\Entity\Account $account
     *
     * @return Account_Follower
     */
    public function setAccount(\AppBundle\Entity\Account $account = null)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return \AppBundle\Entity\Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set follower
     *
     * @param \AppBundle\Entity\Account $follower
     *
     * @return Account_Follower
     */
    public function setFollower(\AppBundle\Entity\Account $follower = null)
    {
        $this->follower = $follower;

        return $this;
    }

    /**
     * Get follower
     *
     * @return \AppBundle\Entity\Account
     */
    public function getFollower()
    {
        return $this->follower;
    }
}
