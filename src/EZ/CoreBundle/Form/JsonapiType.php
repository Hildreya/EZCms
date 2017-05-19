<?php
namespace EZ\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class JsonapiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('jsonapi_ip', TextType::class, array(
                'label' => 'Adresse IP',
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Adresse IP du serveur'
                ),
                'required' => true))
            ->add('jsonapi_port', TextType::class, array(
                'label' => 'Port',
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Port du serveur'
                ),
                'required' => true))
            ->add('jsonapi_username', TextType::class, array(
                'label' => 'Username',
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Username JSONAPI'
                ),
                'required' => true))
            ->add('jsonapi_password', PasswordType::class, array(
                'label' =>'Mot de passe',
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Mot de passe JSONAPI'
                ),
                'required' => true))
            ->add('jsonapi_salt', TextType::class, array(
                'label' =>'Salt',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Salt (facultatif)'
                )))

        ->add('jsonapi_save', SubmitType::class, array(
                'label' => 'Enregistrer',
                'attr' => array('class' => 'button-blue')
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
    }
}