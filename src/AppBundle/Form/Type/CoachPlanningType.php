<?php
/**
 * Created by PhpStorm.
 * User: Guillaume
 * Date: 14/03/2018
 * Time: 11:55
 */

namespace AppBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Entity\Seance;
use AppBundle\Form\Type\SeanceType;

class CoachPlanningType extends AbstractType {
    /** * {@inheritdoc} */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('datedebut', null, array('label' => "Date de début", 'attr' => array('class' => 'datepicker')))
            ->add('heuredebut', null, array('label' => "Heure de début", 'attr' => array('class' => 'timepicker')))
            ->add('datefin', null, array('required' => false, 'label' => 'Date de fin', 'attr' => array('class' => 'datepicker')))
            ->add('heurefin', null, array('required' => false, 'label' => 'Heure de fin', 'attr' => array('class' => 'timepicker')))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\CoachPlanning',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getNom()
    {
        return 'coachPlanning';
    }
}