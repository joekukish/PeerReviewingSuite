<?php

namespace PxS\PeerReviewingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ReviewsController extends Controller
{
    public function indexAction($user)
    {
    	$user = $this->getDoctrine()->getRepository('PxSPeerReviewingBundle:User')
    			->find($user);
    			
		$presentations = $user->getPresentations();

        $reviews = $this->getDoctrine()
    		->getRepository('PxSPeerReviewingBundle:Review')
    		->findBy(array(), array('timestamp'=>'asc'));
	    
        return $this->render('PxSPeerReviewingBundle:Reviews:index.html.twig', array('user' => $user, 'reviews' => $reviews));
    }
}
