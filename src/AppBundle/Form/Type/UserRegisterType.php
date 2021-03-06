<?php
/**
 * Created by PhpStorm.
 * User: PC-Guillaume
 * Date: 05/07/2018
 * Time: 15:54
 */

namespace AppBundle\Form\Type;

use AppBundle\Entity\Jeu;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserRegisterType extends AbstractType
{
    /** * {@inheritdoc} */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('username', null, array('label' => "Nom d'utilisateur", 'attr' => array('class' => 'input-field col s12')))
            ->add('image', FileType::class, array('data_class' => null, 'label' => "Image (png, jpg)", 'required' => false, 'attr' => array('class' => 'mdl-textfield__input')))
            ->add('email', null, array('required' => false, 'label' => 'E-mail', 'attr' => array('class' => 'input-field col s12')))
            ->add('couthoraire', null, array('required' => false, 'label' => 'Coût horraire en GoldCoin (GC)', 'attr' => array('class' => 'input-field col s12')))
            ->add('description', null, array('required' => false, 'label' => 'Description', 'attr' => array('class' => 'input-field col s12')))
            ->add('jeu', EntityType::class, array(
                'attr' => array('class' => 'input-field col s12'),
                'class' => Jeu::class,
            ))
            ->add('roles', CollectionType::class, array(
                    'type' => 'choice',
                    'label' => false,
                    'options' => array(
                        'label' => false,
                        'attr' => array('class' => 'custom-select'),
                        'choices' => array(
                            'ROLE_COACH' => 'Coach'
                        )
                    )
                )
            )
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'Les mots de passe doivent être identiques.',
                'required' => $options['passwordRequired'],
                'first_options'  => array('label' => 'Mot de passe','attr' => array('class' => 'input-field col s12')),
                'second_options' => array('label' => 'Répétez le mot de passe','attr' => array('class' => 'input-field col s12'))
            ))
        ;
        if ($options['lockedRequired']) {
            $builder->add('locked', null, array('required' => false,
                'label' => 'Vérouiller le compte'));
        }

    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
            'passwordRequired' => true,
            'lockedRequired' => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'user';
    }
}