<?php
namespace EZ\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

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
                    'value' => $options['data']['parameters']['facebook']['link']
                )))
            ->add('twitter', TextType::class, array(
                'label' => 'Twitter',
                'attr' => array(
                    'placeholder' => 'Entrez un URL',
                    'value' => $options['data']['parameters']['twitter']['link']
                )))
            ->add('youtube', TextType::class, array(
                'label' => 'youtube',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Entrez un URL',
                    'value' => $options['data']['parameters']['youtube']['link']
            )))

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