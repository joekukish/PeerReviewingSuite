<?php

namespace PxS\PeerReviewingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="comment")
 */
class Comment
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\generatedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
     * @ORM\ManyToOne(targetEntity="Review", inversedBy="comments", cascade={"persist"})
     * @ORM\JoinColumn(name="review_id", referencedColumnName="id", nullable=false)
     * @Assert\Type(type="PxS\PeerReviewingBundle\Entity\Review")
     */
	protected $review;
	
	/**
	 * @ORM\Column(type="string")
	 * @Assert\NotBlank
	 * @Assert\Type("string")
	 * @Assert\Choice({"idea", "presentation"})
	 */
	protected $type;

	/**
	 * @ORM\Column(type="text")
	 * @Assert\NotBlank
	 * @Assert\Type("string")
	 */
	protected $description;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 * @Assert\Type("string")
	 */
	protected $score;

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
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set score
     *
     * @param string $score
     */
    public function setScore($score)
    {
        $this->score = $score;
    }

    /**
     * Get score
     *
     * @return string 
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set review
     *
     * @param PxS\PeerReviewingBundle\Entity\Review $review
     */
    public function setReview(\PxS\PeerReviewingBundle\Entity\Review $review)
    {
        $this->review = $review;
    }

    /**
     * Get review
     *
     * @return PxS\PeerReviewingBundle\Entity\Review 
     */
    public function getReview()
    {
        return $this->review;
    }
}