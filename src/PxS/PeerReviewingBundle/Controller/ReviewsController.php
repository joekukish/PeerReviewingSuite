<?php

namespace PxS\PeerReviewingBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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
    	// gets the current user of the application
    	$user = $this->getUser();

    	// gets the reviews in which the current user was the presenter
    	// meaning that he got some feedback.
        $reviews = $this->getDoctrine()
    		->getRepository('PxSPeerReviewingBundle:Review')
    		->findBy(array('presenter'=>$user->getId()), array('assignment'=>'DESC', 'timestamp'=>'DESC'));


		// array where the reviews will be grouped by assignment.
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

        return $this->render('PxSPeerReviewingBundle:Reviews:feedback.html.twig', array('page'=>'feedback', 'reviews' => $groupedReviews));
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
			// indicates that it was not created successfully.
			$this->get('session')->setFlash('error', 'Failed to create the review');
		}
    	
    	return $this->render('PxSPeerReviewingBundle:Reviews:new.html.twig', array('page'=>'new-review', 'form'=> $form->createView()));
    }
    
    public function detailAction($id)
    {
    	// gets the current user of the app.
        $user = $this->getUser();

        // finds the review using the id.
		$review = $this->getDoctrine()->getRepository('PxSPeerReviewingBundle:Review')
    			->find($id);

	    if (!$review) {
	        // throw $this->createNotFoundException('No review found with the given id '.$id);
	        return $this->redirect($this->generateUrl('PxSPeerReviewingBundle_reviews'));
	    }
	    
	    if($review->getReviewer()->getId() == $user->getId())
			return $this->render('PxSPeerReviewingBundle:Reviews:detail.html.twig', array('page'=>'reviews', 'review' => $review));
	    else if($review->getPresenter()->getId() == $user->getId())
	    	return $this->render('PxSPeerReviewingBundle:Reviews:detail.html.twig', array('page'=>'feedback', 'review' => $review));
	    
	    // goes back to the reviews page since the user doesn't have permissions to view the page.
		return $this->redirect($this->generateUrl('PxSPeerReviewingBundle_reviews'));
    }
}
