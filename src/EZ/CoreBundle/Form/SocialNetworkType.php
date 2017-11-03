<?php
namespace EZ\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Asset\Packages;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SocialNetworkType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var \Symfony\Component\Asset\Package $asset */
        $asset = $options['asset'];

        $builder
            ->add('name', TextType::class, array(
                'label' => false,
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Entrer le nom de votre réseau social',
                )
            ))
            ->add('link', TextType::class, array(
                'label' => false,
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Entrer une URL',
                )

            ))
            ->add('icons_selector', ChoiceType::class, array(
                'required' => true,
                'label' => false,
                'attr' => array('class'=>'icons_selector'),
                'choices' => array(
                    '' => $asset->getUrl('img/svg/facebook.svg'),
                    ' ' => $asset->getUrl('img/svg/twitter.svg'),
                    '  ' => $asset->getUrl('img/svg/youtube.svg'),
                    '' => $asset->getUrl('img/svg/github.svg'),
                    '     ' => $asset->getUrl('img/svg/googleplus.svg'),
                    '       ' => $asset->getUrl('img/svg/skype.svg'),
                    '        ' => $asset->getUrl('img/svg/instagram.svg'),
                    '         ' => $asset->getUrl('img/svg/discord.svg'),
                    '          ' =>$asset->getUrl('img/svg/ts3.svg')

                ),
                'choice_attr' => function($key) {
                    return ['data-imagesrc' => $key];
                },
            ))
            ->add('enregistrer', SubmitType::class, array(
                'attr' => array(
                    'class' => 'button-green'
                )))
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('asset');
    }
}