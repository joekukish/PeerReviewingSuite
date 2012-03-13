<?php

namespace PxS\PeerReviewingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DashboardController extends Controller
{
    public function indexAction($user)
    {
        return $this->render('PxSPeerReviewingBundle:Dashboard:index.html.twig', array('name' => 'Oscar!'));
    }
}
