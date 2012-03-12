<?php

namespace PxS\PeerReviewingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="peerreview")
 */
class PeerReview
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\generatedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\JoinColumn(name="comment_id", referencedColumnName="id")
	 */
	protected $comment;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $score;
}