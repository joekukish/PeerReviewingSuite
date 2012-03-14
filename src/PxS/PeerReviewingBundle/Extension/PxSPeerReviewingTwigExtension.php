<?php

namespace PxS\PeerReviewingBundle\Extension;
	
class PxSPeerReviewingTwigExtension extends \Twig_Extension
{       
    public function getFilters()
    {
        return array (
            'md5'   => new \Twig_Filter_Function('md5'),
			'trim'  => new \Twig_Filter_Function('trim')
        );
    } 

    public function getName()
    {
        return 'pxs_peer_reviewing_twig_extension';
    }     
}