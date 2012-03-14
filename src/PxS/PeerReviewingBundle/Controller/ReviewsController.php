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
	    
        return $this->render('PxSPeerReviewingBundle:Reviews:index.html.twig', array('page'=>'reviews', 'user' => $user, 'reviews' => $user->getReviews()));
    }
    
    public function peerAction($user)
    {
    	$user = $this->getDoctrine()->getRepository('PxSPeerReviewingBundle:User')
    			->find($user);

//        $reviews = $this->getDoctrine()
//    		->getRepository('PxSPeerReviewingBundle:Review')
//    		->findBy(array(), array('timestamp'=>'asc'));
	    
        return $this->render('PxSPeerReviewingBundle:Reviews:index.html.twig', array('page'=>'peer-reviews', 'user' => $user, 'reviews' => $user->getPresentations()));
    }    
    
    public function detailAction($user, $review)
    {
        $user = $this->getDoctrine()->getRepository('PxSPeerReviewingBundle:User')
    			->find($user);
    			
		$review = $this->getDoctrine()->getRepository('PxSPeerReviewingBundle:Review')
    			->find($review);

		$page = $review->getReviewer()->getId() == $user->getId()? 'reviews':'peer-reviews';
    			
		
		return $this->render('PxSPeerReviewingBundle:Reviews:detail.html.twig', array('page'=>$page, 'user' => $user, 'review' => $review));
    }
}
