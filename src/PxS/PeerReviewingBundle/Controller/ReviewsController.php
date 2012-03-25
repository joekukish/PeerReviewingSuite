<?php

namespace PxS\PeerReviewingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ReviewsController extends Controller
{
    public function reviewsAction($user)
    {
    	$user = $this->getDoctrine()->getRepository('PxSPeerReviewingBundle:User')
    			->find($user);

//        $reviews = $this->getDoctrine()
//    		->getRepository('PxSPeerReviewingBundle:Review')
//    		->findBy(array(), array('timestamp'=>'asc'));
	    
        return $this->render('PxSPeerReviewingBundle:Reviews:reviews.html.twig', array('page'=>'reviews', 'user' => $user, 'reviews' => $user->getReviews()));
    }
    
    public function feedbackAction($user)
    {
    	$user = $this->getDoctrine()->getRepository('PxSPeerReviewingBundle:User')
    			->find($user);

//        $reviews = $this->getDoctrine()
//    		->getRepository('PxSPeerReviewingBundle:Review')
//    		->findBy(array(), array('timestamp'=>'asc'));
	    
        return $this->render('PxSPeerReviewingBundle:Reviews:feedback.html.twig', array('page'=>'feedback', 'user' => $user, 'reviews' => $user->getPresentations()));
    }    
    
    public function detailAction($user, $review)
    {
        $user = $this->getDoctrine()->getRepository('PxSPeerReviewingBundle:User')
    			->find($user);
    			
		$review = $this->getDoctrine()->getRepository('PxSPeerReviewingBundle:Review')
    			->find($review);

		$page = $review->getReviewer()->getId() == $user->getId()? 'reviews':'feedback';
    			
		
		return $this->render('PxSPeerReviewingBundle:Reviews:detail.html.twig', array('page'=>$page, 'user' => $user, 'review' => $review));
    }
}
