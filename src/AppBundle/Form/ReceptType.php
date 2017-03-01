<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use AppBundle\Form\Type\IngredientType;
use AppBundle\Entity\Recept;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class ReceptType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('titel', TextType::class)
        	->add('beschrijving', TextareaType::class, array(
        		'required' => false,
        		'attr' => array('rows' => 5, 'cols' => 60),
        		))
        	->add('bereidingstijd', TimeType::class, array(
        		'required' => false,
        		'input' => 'string',
        		'widget' => 'text',
        		))        		
        	-> add('ingredienten', CollectionType::class, array(
        		'required' => false,
        		'entry_type' => IngredientType::class,
        		'allow_add' => true,
        		'allow_delete' => true,
        		'by_reference' => false,
        		))
			->add('ingredienten_bulk', TextAreaType::class, array(
        		'mapped' => false,
        		'attr' => array('rows' => 5, 'cols' => 60),
        		))
        	->add('bereidingswijze', TextareaType::class, array(
        		'required' => false,
        		'attr'=>array('rows'=>5, 'cols'=>60),
        		))
        	->add('fotoBestand', VichImageType::class, [
            	'required' => false,
            	'allow_delete' => true, // not mandatory, default is true
            	'download_link' => true, // not mandatory, default is true
        		])
        	->add('gerecht', EntityType::class, array(
        		'required' => false,
				'class' => 'AppBundle:Gerecht',
				'choice_label' => 'name',
				'multiple' => false,
				'expanded' => false,
				))
        	->add('keuken', EntityType::class, array(
        		'required' => false,
				'class' => 'AppBundle:Keuken',
				'choice_label' => 'name',
				'multiple' => false,
				'expanded' => false,
				))
        	->add('hoofdingredient', EntityType::class, array(
        		'required' => false,
				'class' => 'AppBundle:Hoofdingredient',
				'choice_label' => 'name',
				'multiple' => false,
				'expanded' => false,
				))
        	->add('tags', Select2EntityType::class, array(
        		'multiple' => true,
        		'required' => false,
				'class' => 'AppBundle:Tag',
				'primary_key' => 'id',
				'remote_route' => 'findtag',
				'text_property' => 'name',
				'allow_clear' => true,
				'placeholder' => 'Selecteer een tag',
				'minimum_input_length' => 0,
				'language' => 'nl',
				))
        	->add('kostprijs', MoneyType::class, array(
        		'required' => false,
        		))
        	->add('id', HiddenType::class, array(
        		'required' => false,
        		'mapped' => false,
        		))
        	->add('bewaar', SubmitType::class, array(
        		'label' => 'Bewaar recept'
        		))
        ;		

        	
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Recept::class,
        ));
    }
}