<?php
/**
 * Created by PhpStorm.
 * User: PC-Guillaume
 * Date: 04/07/2018
 * Time: 10:08
 */

namespace AppBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class JeuType extends AbstractType
{
    /** * {@inheritdoc} */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('nom', null, array('label' => "Nom du programme", 'attr' => array('class' => 'input-field col s12')))
            ->add('image', FileType::class, array('data_class' => null, 'label' => "Image (png, jpg)", 'required' => false, 'attr' => array('class' => 'mdl-textfield__input')))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Jeu',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getNom()
    {
        return 'jeu';
    }
}