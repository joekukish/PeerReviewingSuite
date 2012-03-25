<?php

namespace PxS\PeerReviewingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;


class PeerReviewingBundleBaseController extends BaseController {
	
	public function getUser()
    {
        if (!$this->container->has("security.context")) {
            throw new \LogicException("The SecurityBundle is not registered in your application.");
        }

        $token = $this->container->get("security.context")->getToken();

        if ($token && is_object($token->getUser())) {
            return $token->getUser();
        }
    }
}