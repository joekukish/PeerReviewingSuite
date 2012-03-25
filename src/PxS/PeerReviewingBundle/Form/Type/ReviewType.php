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
			'choices'=>array('4.0'=>'4 Pass', '4.5'=>'4.5 satisfactory', '5.0'=> '5 good', '5.5'=>'5.5 very good', '6.0'=> '6 excellent')
		));
		$builder->add('comments', 'collection', array('type'=> new CommentType()));
	    $builder->add('presenter', 'entity', array(
	    			'class'=>'PxS\PeerReviewingBundle\Entity\User', 'property'=>'name',
				    'query_builder' => function(EntityRepository $er) use ($id) {
				    	return $er->createQueryBuilder('u')
				    		->where('u.id <> :id')
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