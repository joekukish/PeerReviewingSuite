<?php

namespace PxS\PeerReviewingBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
	    $builder->add('description', 'textarea');
    }

    public function getName()
    {
        return 'comment';
    }
    
	public function getDefaultOptions(array $options)
	{
	    return array(
	        'data_class' => 'PxS\PeerReviewingBundle\Entity\Comment',
	    );
	}    
}