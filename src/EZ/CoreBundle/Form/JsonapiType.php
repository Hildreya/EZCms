<?php

namespace EZ\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use EZ\CoreBundle\Entity\Jsonapi;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class JsonapiType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ip', null, array(
                'label' => 'Adresse IP'
            ))
            ->add('port', null, array(
                'label' => 'Port'
            ))
            ->add('username', null, array(
                'label' => 'Nom d\'utilisateur'
            ))
            ->add('password', PasswordType::class, array(
                'label' => 'Mot de pass'
            ))
            ->add('position', ChoiceType::class, array(
                'label' => 'Position',
                'placeholder' => 'Position',
                'choices' => $options['position']
                )
            )
            ->add('submit', SubmitType::class, array(
                'label' => 'Sauvegarder',
                'attr' => array('class' => 'button-green')
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EZ\CoreBundle\Entity\Jsonapi',
            'position' => array()
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ez_corebundle_jsonapi';
    }


}
