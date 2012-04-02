<?php

namespace PxS\PeerReviewingBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

use PxS\PeerReviewingBundle\Entity\Review;
use PxS\PeerReviewingBundle\Entity\Comment;
use PxS\PeerReviewingBundle\Form\Type\ReviewType;
use PxS\PeerReviewingBundle\Form\Type\CommentFeedbackType;

class StatisticsController extends PeerReviewingBundleBaseController
{
    public function statsAction()
    {
    	// blocks unwanted users.
		if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
        	throw new AccessDeniedException();
    	}
		
		$stats = $this->getDoctrine()->getEntityManager()
			->createQueryBuilder()
			->add('select', 'r, AVG(r.score) as average_score')
			->add('from', 'PxSPeerReviewingBundle:Review r')
			//->add('orderBy', 'r.presenter->getId()id DESC')
			->add('groupBy', 'r.presenter, r.assignment')
			->getQuery();
	    		
		// renders the reviews page with the grouped reviews.
        return $this->render('PxSPeerReviewingBundle:Statistics:stats.html.twig', array('page'=>'stats', 'reviews' => $stats->getResult()));
    }
    
    private function groupReviewsByAssignment($reviews)
    {
    	$groupedReviews = array();	
		// groups the reviews by assignment
		foreach ($reviews as $i => $entry)
		{
			// creates the group if it didn't exist
			if(!isset($groupedReviews[$entry->getAssignment()]))
				$groupedReviews[$entry->getAssignment()] = array();
				
			// adds the review to the group.
			$groupedReviews[$entry->getAssignment()][] = $entry;
		}
		
		return $groupedReviews;
    }
}
