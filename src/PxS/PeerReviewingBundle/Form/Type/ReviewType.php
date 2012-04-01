<?php

namespace PxS\PeerReviewingBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
    	// id of the user writing the review.
    	$id = $options['data']->getReviewer()->getId();
    	
		$builder->add('score', 'choice', array(
			'choices'=>array('3.5'=>'< 4.0 Fail', '4.0'=>'4 Pass', '4.5'=>'4.5 Satisfactory', '5.0'=> '5 Good', '5.5'=>'5.5 Very Good', '6.0'=> '6 Excellent'),
			'empty_value'=>'Rate the presentation',
			'empty_data'=>null
		));
		$builder->add('comments', 'collection', array('type'=> new CommentType()));
	    $builder->add('presenter', 'entity', array(
	    			'class'=>'PxS\PeerReviewingBundle\Entity\User', 'property'=>'name',
				    'query_builder' => function(EntityRepository $er) use ($id) {
				    	return $er->createQueryBuilder('u')
				    	// only ROLE_USER users are shown
				    		->where('u.id <> :id AND u.roles = \'a:0:{}\' ')
				    		->orderBy('u.name', 'ASC')
				    		->setParameter('id', $id);
	    			}
	    ));
    }

    public function getName()
    {
        return 'review';
    }
    
	public function getDefaultOptions(array $options)
	{
	    return array(
	        'data_class' => 'PxS\PeerReviewingBundle\Entity\Review',
	    );
	}    
}