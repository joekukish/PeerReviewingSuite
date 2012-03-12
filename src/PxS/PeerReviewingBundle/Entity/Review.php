<?php

namespace PxS\PeerReviewingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="review")
 */
// (repositoryClass="PxS\PeerReviewingBundle\Entity\UserRepository")
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
	 * @ORM\Column(type="float")
	 */
	protected $score;
	/**
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="presentations")
	 * @ORM\JoinColumn(name="presenter_id", referencedColumnName="id")
	 */
	protected $presenter;

	/**
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="reviews")
	 * @ORM\JoinColumn(name="reviewer_id", referencedColumnName="id")
	 */
	protected $reviewer;

	public function __construct()
	{
		$this->comments = new ArrayCollection();
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
	 * Set timestamp
	 *
	 * @param datetime $timestamp
	 */
	public function setTimestamp($timestamp)
	{
		$this->timestamp = $timestamp;
	}

	/**
	 * Get timestamp
	 *
	 * @return datetime
	 */
	public function getTimestamp()
	{
		return $this->timestamp;
	}

	/**
	 * Set score
	 *
	 * @param float $score
	 */
	public function setScore($score)
	{
		$this->score = $score;
	}

	/**
	 * Get score
	 *
	 * @return float
	 */
	public function getScore()
	{
		return $this->score;
	}

	/**
	 * Set presenter
	 *
	 * @param string $presenter
	 */
	public function setPresenter($presenter)
	{
		$this->presenter = $presenter;
	}

	/**
	 * Get presenter
	 *
	 * @return string
	 */
	public function getPresenter()
	{
		return $this->presenter;
	}

	/**
	 * Set reviewer
	 *
	 * @param string $reviewer
	 */
	public function setReviewer($reviewer)
	{
		$this->reviewer = $reviewer;
	}

	/**
	 * Get reviewer
	 *
	 * @return string
	 */
	public function getReviewer()
	{
		return $this->reviewer;
	}

	/**
	 * Add comments
	 *
	 * @param PxS\PeerReviewingBundle\Entity\Comment $comments
	 */
	public function addComment(\PxS\PeerReviewingBundle\Entity\Comment $comments)
	{
		$this->comments[] = $comments;
	}

	/**
	 * Get comments
	 *
	 * @return Doctrine\Common\Collections\Collection
	 */
	public function getComments()
	{
		return $this->comments;
	}
}