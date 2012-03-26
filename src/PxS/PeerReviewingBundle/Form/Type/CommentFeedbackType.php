<?php

namespace PxS\PeerReviewingBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CommentFeedbackType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
		$builder->add('score', 'choice', array(
			'choices'=>array('4.0'=>'4 Pass', '4.5'=>'4.5 Satisfactory', '5.0'=> '5 Good', '5.5'=>'5.5 Very Good', '6.0'=> '6 Excellent'),
		));
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