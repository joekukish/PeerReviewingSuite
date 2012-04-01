<?php

namespace PxS\PeerReviewingBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

use PxS\PeerReviewingBundle\Entity\Review;
use PxS\PeerReviewingBundle\Entity\Comment;
use PxS\PeerReviewingBundle\Form\Type\ReviewType;
use PxS\PeerReviewingBundle\Form\Type\CommentFeedbackType;

class ReviewsController extends PeerReviewingBundleBaseController
{
    public function reviewsAction()
    {
    	// gets the current user of the application
    	$user = $this->getUser();

    	$userFilter = array();
    	
	    // if it's not an admin, the reviews are limited to a single user.
	    if (!$this->get('security.context')->isGranted('ROLE_ADMIN'))
			$userFilter = array('reviewer'=>$user->getId());
	    
	    // obtains the reviews from the database.
		$reviews = $this->getDoctrine()
	    		->getRepository('PxSPeerReviewingBundle:Review')
	    		->findBy($userFilter, array('assignment'=>'DESC', 'timestamp'=>'DESC'));	    		
	    		
		// renders the reviews page with the grouped reviews.
        return $this->render('PxSPeerReviewingBundle:Reviews:reviews.html.twig', array('page'=>'reviews', 'reviews' => $this->groupReviewsByAssignment($reviews)));
    }

    public function feedbackAction()
    {
    	// gets the current user of the application
    	$user = $this->getUser();

    	// gets the reviews in which the current user was the presenter
    	// meaning that he got some feedback.
//        $reviews = $this->getDoctrine()
//    		->getRepository('PxSPeerReviewingBundle:Review')
//    		->findBy(array('presenter'=>$user->getId(), 'timestamp'=>now()), array('assignment'=>'DESC', 'timestamp'=>'DESC'));

    	// feedback is shown one day later.
		$reviews = $this->getDoctrine()->getRepository('PxSPeerReviewingBundle:Review')
					->createQueryBuilder('r')
						->where('r.presenter = :presenter AND DATE_DIFF(:now, r.timestamp) > 0')
			    		->orderBy('r.timestamp', 'DESC')
			    		->setParameter('presenter', $user->getId())
			    		->setParameter('now', date('Y-m-d H:i:s'))
			    			->getQuery()->getResult();

    	// renders the feedback page with the grouped reviews.
        return $this->render('PxSPeerReviewingBundle:Reviews:feedback.html.twig', array('page'=>'feedback', 'reviews' => $this->groupReviewsByAssignment($reviews)));
    }

    public function newAction(Request $request)
    {
    	// gets the current user
    	$user = $this->getUser();
    	
    	// creates a new review
    	$review = new Review;
    	// hard-wires the active assignment
    	$review->setAssignment('Second Review');
    	// sets the reviewer based on the session.
    	$review->setReviewer($user);
    	$review->setTimestamp(new \DateTime('now'));

		// creates the initial comments
    	for($i = 0; $i < 3; $i++)
    	{
	    	$comment = new Comment();
	    	$comment->setType('idea');
	    	$comment->setReview($review);
	    	$review->addComment($comment);
    	}
    	
    	// adds one presentation comment.
    	$comment = new Comment();
    	$comment->setType('presentation');
    	$comment->setReview($review);
    	$review->addComment($comment);
    	
    	// creates the form used to fill the data.
    	$form = $this->createForm(new ReviewType(), $review);
    		
		// checks if a a new Review needs to be stored into the database
		if($request->getMethod() == 'POST')
		{
			$form->bindRequest($request);
			if($form->isValid())
			{
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
    
    public function detailAction(Request $request, $id)
    {
    	// gets the current user of the app.
        $user = $this->getUser();

        // finds the review using the id.
		$review = $this->getDoctrine()->getRepository('PxSPeerReviewingBundle:Review')
    			->find($id);

		// checks if the review exists.
	    if (!$review)
	        // throw $this->createNotFoundException('No review found with the given id '.$id);
	        return $this->redirect($this->generateUrl('PxSPeerReviewingBundle_reviews'));
	    
    	// creates the form used to fill the data.
    	$form = $this->createFormBuilder($review)
    		->add('comments', 'collection', array('type'=> new CommentFeedbackType()))
    		->getForm();

    	// checks if the review is being updated.
		if($request->getMethod() == 'POST') {
			$form->bindRequest($request);
			if($form->isValid()) {
				
				// stores the object into the DB.
				$em = $this->getDoctrine()->getEntityManager();
				$em->persist($review);
				$em->flush();
				
				$this->get('session')->setFlash('success', 'The comment scores were updated successfully!');
			} else {
				// indicates that it was not created successfully.
				$this->get('session')->setFlash('error', 'The comment scores could not be saved.');
			}
		}
		
	    // gets the page based on the ownership of the review.
	    $page = $review->getReviewer()->getId() == $user->getId() ? 'reviews' : 'feedback'; 
	    
	    // 'review' => $review
		return $this->render('PxSPeerReviewingBundle:Reviews:detail.html.twig', array('page'=>$page, 'form'=> $form->createView()));
    }
    
    /**
     * Groups the reviews based on the assignments.
     * 
     * @param $reviews reviews obtained from the DB that need to be grouped.
     * 
     * @return returns  	an array whose keys are the assignments and contain an array of the reviews that match that key.
     */
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
