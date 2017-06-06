<?php

namespace EZ\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ReglementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('activate', CheckboxType::class, array(
                    'label' => 'Activer le réglement',
                    'required' => false
                )
            )
            ->add('content', null, array(
                'label' => 'Réglement',
                'attr' => array(
                    'class' => 'ckeditor'
                )))
            ->add('submit', SubmitType::class, array(
                'label' => 'Sauvegarder',
                'attr' => array(
                    'class' => 'button-green'
                )));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EZ\CoreBundle\Entity\Reglement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ez_corebundle_reglement';
    }


}
