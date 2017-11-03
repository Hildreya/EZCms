<?php

namespace EZ\UserBundle\Form;

use function Sodium\add;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
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
        $builder->remove('plainPassword');
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'ez_user_registration';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }


}
