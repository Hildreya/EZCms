<?php

namespace EZ\UserBundle\Form;

use EZ\UserBundle\Entity\Group;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /*->add('roles', ChoiceType::class, array(
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
            ));*/
            ->add('groups', EntityType::class, array(
                'label' => "Groupe",
                'class' => 'EZ\UserBundle\Entity\Group',
                'choice_label' => 'name',
                'multiple' => true,
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'ez_user_admin_registration_type';
    }
}
