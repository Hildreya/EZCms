<?php

namespace EZ\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class LegalType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('activate_cc', CheckboxType::class, array(
                    'label' => 'Activer les CGV / CGU',
                    'required' => false,
                    'attr' => array(
                        'class' => 'minimal'
                    )
                )
            )
            ->add('cgvCgu', null , array(
                    'label' => 'CGV / CGU',
                    'attr' => array('class' => 'ckeditor')
                )
            )
            ->add('activate_lm', CheckboxType::class, array(
                    'label' => 'Activer les mentions légales',
                    'required' => false
                )
            )
            ->add('legalMention', null , array(
                    'label' => 'Mentions Légales',
                    'attr' => array('class' => 'ckeditor')
                )
            )
            ->add('submit', SubmitType::class, array(
                    'label' => 'Sauvegarder',
                    'attr' => array('class' => 'button-green')
                )
            );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EZ\CoreBundle\Entity\Legal'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ez_corebundle_legal';
    }


}
