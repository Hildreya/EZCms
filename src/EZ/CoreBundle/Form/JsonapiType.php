<?php

namespace EZ\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class JsonapiType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('position', null, array(
                'label' => 'Position'
            ))
            ->add('ip', null, array(
                'label' => 'Adresse IP'
            ))
            ->add('port', null, array(
                'label' => 'Port'
            ))
            ->add('username', null, array(
                'label' => 'Nom d\'utilisateur'
            ))
            ->add('password', null, array(
                'label' => 'Mot de pass'
            ))
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
            'data_class' => 'EZ\CoreBundle\Entity\Jsonapi'
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
