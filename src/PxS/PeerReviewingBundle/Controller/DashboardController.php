<?php

namespace PxS\PeerReviewingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DashboardController extends Controller
{
    public function indexAction()
    {
        return $this->render('PxSPeerReviewingBundle:Homepage:index.html.twig', array('name' => 'Oscar!'));
    }
}
