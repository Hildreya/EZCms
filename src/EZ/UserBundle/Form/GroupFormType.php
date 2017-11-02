<?php

namespace EZ\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove('name');
        $builder
            ->add('name', null, array(
                'label' => 'form.group_name',
                'translation_domain' => 'FOSUserBundle',
                'required' => true,
            ))
            ->add('roles', ChoiceType::class, array(
            'attr'  =>  array('class' => 'form-control select2',
                'style' => 'margin:5px 0;'),
            'choices' =>
                array
                (
                    'Administrateur' => 'ROLE_ADMIN',
                    'Modérateur' => 'ROLE_MODO',
                    'Utilisateur' => 'ROLE_USER'
                ) ,
            'multiple' => true,
            'required' => true,
        ));
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\GroupFormType';
    }


    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getBlockPrefix()
    {
        return 'ez_group_form';
    }
}
