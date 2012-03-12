<?php

namespace PxS\PeerReviewingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="review")
 */
class Review
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	/**
     * @ORM\Column(type="datetime")
     */
	protected $timestamp;
	/**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="review")
     */
	protected $comments;
	/**
     * @ORM\Column(type="double")
     */
	protected $overall;
	/**
     * @ORM\Column(type="text")
     */
	protected $presenter;
	/**
     * @ORM\Column(type="text")
     */
	protected $reviewer;
	/**
	 * @ORM\Column(type="text")
	 */
	protected $name;
	
    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }
}