<?php

namespace PxS\PeerReviewingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class HomepageController extends Controller
{
    public function indexAction()
    {
    	$users = $this->getDoctrine()
    		->getRepository('PxSPeerReviewingBundle:User')
    		->findBy(array(), array('name'=>'asc'));

	    if (!$users) {
	        throw $this->createNotFoundException('No product found for id ');
	    }		
    		
        return $this->render('PxSPeerReviewingBundle:Homepage:index.html.twig', array('users' => $users));
    }
}
