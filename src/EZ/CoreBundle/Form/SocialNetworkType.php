<?php
namespace EZ\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SocialNetworkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('facebook', TextType::class, array(
                'label' => 'Facebook ',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Entrez un URL',
                    'value' => $options['data']['parameters']['icons']['facebook']['link']
                )))
            ->add('twitter', TextType::class, array(
                'label' => 'Twitter',
                'attr' => array(
                    'placeholder' => 'Entrez un URL',
                    'value' => $options['data']['parameters']['icons']['twitter']['link']
                )))
            ->add('youtube', TextType::class, array(
                'label' => 'youtube',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Entrez un URL',
                    'value' => $options['data']['parameters']['icons']['youtube']['link']
            )))
            ->add('name', TextType::class, array(
                'label' => false,
                'required' => false,
                'attr' => array(
                    'class' => 'hidden',
                    'placeholder' => 'Entrer le nom de   votre réseau social',
                )
            ))
            ->add('icon', ChoiceType::class, array(
                'required' => false,
                'label' => false,
                'choices' => array(
                    'facebook' => '57705',
                    'twitter' => '57709',
                    //'youtube' => '',
                    'github' => '57738',
                    'google+' => '57700',
                    'reddit' => '57758',
                    'pinterest' => '57766',

                ),
                'attr' => array(
                    'placeholder' => 'Veuillez entrer une icon (TO WORK ON)',
                    'class' => 'icon_selector',
                )
            ))
            ->add('link', TextType::class, array(
                'label' => false,
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Entrer un URL',
                    'class' => 'hidden',
                )

            ))

            ->add('Submit', SubmitType::class, array(
                'attr' => array(
                    'class' => 'button-green'
                )))
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
    }
}