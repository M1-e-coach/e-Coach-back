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

class ProgrammeType extends AbstractType {
    /** * {@inheritdoc} */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('nom', null, array('label' => "Nom du programme", 'attr' => array('class' => 'input-field col s12')))
            ->add('description', null, array('required' => false, 'label' => 'Description', 'attr' => array('class' => 'input-field col s12')))
            ->add('coin', null, array('required' => false, 'label' => 'Nombre de Gold Coin', 'attr' => array('class' => 'input-field col s12')))
            ->add('semaine', null, array('required' => false, 'label' => 'Numéro de semaine', 'attr' => array('class' => 'input-field col s12')))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Programme',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getNom()
    {
        return 'programme';
    }
}