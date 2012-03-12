<?php

namespace PxS\PeerReviewingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
// (repositoryClass="PxS\PeerReviewingBundle\Entity\UserRepository")
class User
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\generatedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", unique="true")
	 */
	protected $name;

	/**
	 * @ORM\OneToMany(targetEntity="Review", mappedBy="reviewer")
	 */
	protected $reviews;

	/**
	 * @ORM\OneToMany(targetEntity="Review", mappedBy="presenter")
	 */
	protected $presentations;

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
	 * Set name
	 *
	 * @param text $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * Get name
	 *
	 * @return text
	 */
	public function getName()
	{
		return $this->name;
	}
	public function __construct()
	{
		$this->reviews = new \Doctrine\Common\Collections\ArrayCollection();
		$this->presentations = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * Add reviews
	 *
	 * @param PxS\PeerReviewingBundle\Entity\Review $reviews
	 */
	public function addReview(\PxS\PeerReviewingBundle\Entity\Review $reviews)
	{
		$this->reviews[] = $reviews;
	}

	/**
	 * Get reviews
	 *
	 * @return Doctrine\Common\Collections\Collection
	 */
	public function getReviews()
	{
		return $this->reviews;
	}

	/**
	 * Get presentations
	 *
	 * @return Doctrine\Common\Collections\Collection
	 */
	public function getPresentations()
	{
		return $this->presentations;
	}
}