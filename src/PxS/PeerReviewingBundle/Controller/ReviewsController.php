<?php

namespace PxS\PeerReviewingBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use PxS\PeerReviewingBundle\Entity\Review;
use PxS\PeerReviewingBundle\Entity\Comment;
use PxS\PeerReviewingBundle\Form\Type\ReviewType;

class ReviewsController extends PeerReviewingBundleBaseController
{
    public function reviewsAction()
    {
    	$user = $this->getUser();

//        $reviews = $this->getDoctrine()
//    		->getRepository('PxSPeerReviewingBundle:Review')
//    		->findBy(array(), array('timestamp'=>'asc'));
	    
        return $this->render('PxSPeerReviewingBundle:Reviews:reviews.html.twig', array('page'=>'reviews', 'reviews' => $user->getReviews()));
    }
    
    public function feedbackAction()
    {
    	$user = $this->getUser();

//        $reviews = $this->getDoctrine()
//    		->getRepository('PxSPeerReviewingBundle:Review')
//    		->findBy(array(), array('timestamp'=>'asc'));
	    
        return $this->render('PxSPeerReviewingBundle:Reviews:feedback.html.twig', array('page'=>'feedback', 'reviews' => $user->getPresentations()));
    }

    public function newAction(Request $request)
    {
    	// gets the current user
    	$user = $this->getUser();
    	
    	// creates a new review
    	$review = new Review;
    	// hard-wires the active assignment
    	$review->setAssignment('First Review');
    	// sets the reviewer based on the session.
    	$review->setReviewer($user);
    	$review->setTimestamp(new \DateTime('now'));

    	// creates the initial comments
    	$comment = new Comment();
    	$comment->setType('idea');
    	$comment->setDescription('Esta es una prueba');
    	$comment->setReview($review);

    	$review->addComment($comment);
    	
    	// creates the form used to fill the data.
    	$form = $this->createForm(new ReviewType(), $review);
    		
		// checks if a a new Review needs to be stored into the database
		if($request->getMethod() == 'POST') {
			$form->bindRequest($request);
			if($form->isValid()) {
				
				// stores the object into the DB.
				$em = $this->getDoctrine()->getEntityManager();
				$em->persist($review);
				$em->flush();
				
				$this->get('session')->setFlash('success', 'The review was created successfully!');
				// goes back to the reviews page.
				return $this->redirect($this->generateUrl('PxSPeerReviewingBundle_reviews'));
			}
			
			$this->get('session')->setFlash('error', 'Failed to create the review');
			
		}
    	
    	return $this->render('PxSPeerReviewingBundle:Reviews:new.html.twig', array('page'=>'new-review', 'form'=> $form->createView()));
    }
    
    public function detailAction($id)
    {
        $user = $this->getUser();
    			
		$review = $this->getDoctrine()->getRepository('PxSPeerReviewingBundle:Review')
    			->find($id);

	    if (!$review) {
	        throw $this->createNotFoundException('No review found with the given id '.$id);
	    }
		// $page = $review->getReviewer()->getId() == $user->getId()? 'reviews':'feedback';
    	$page = 'reviews';
		
		return $this->render('PxSPeerReviewingBundle:Reviews:detail.html.twig', array('page'=>$page, 'review' => $review));
    }
}
