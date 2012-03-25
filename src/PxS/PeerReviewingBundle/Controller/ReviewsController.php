<?php

namespace PxS\PeerReviewingBundle\Controller;

class ReviewsController extends PeerReviewingBundleBaseController
{
    public function reviewsAction()
    {
    	$user = $this->getUser();

//        $reviews = $this->getDoctrine()
//    		->getRepository('PxSPeerReviewingBundle:Review')
//    		->findBy(array(), array('timestamp'=>'asc'));
	    
        return $this->render('PxSPeerReviewingBundle:Reviews:reviews.html.twig', array('page'=>'reviews', 'user' => $user, 'reviews' => $user->getReviews()));
    }
    
    public function feedbackAction()
    {
    	$user = $this->getUser();

//        $reviews = $this->getDoctrine()
//    		->getRepository('PxSPeerReviewingBundle:Review')
//    		->findBy(array(), array('timestamp'=>'asc'));
	    
        return $this->render('PxSPeerReviewingBundle:Reviews:feedback.html.twig', array('page'=>'feedback', 'user' => $user, 'reviews' => $user->getPresentations()));
    }    
    
    public function detailAction($review)
    {
        $user = $this->getUser();
    			
		$review = $this->getDoctrine()->getRepository('PxSPeerReviewingBundle:Review')
    			->find($review);

		$page = $review->getReviewer()->getId() == $user->getId()? 'reviews':'feedback';
    			
		
		return $this->render('PxSPeerReviewingBundle:Reviews:detail.html.twig', array('page'=>$page, 'user' => $user, 'review' => $review));
    }
}
