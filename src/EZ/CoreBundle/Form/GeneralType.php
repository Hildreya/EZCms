<?php
namespace EZ\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class GeneralType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('server_name', null, array(
                'label' => 'Nom du serveur',
                'attr' => array(
                    'value' => $options['parameters']['server_name']
                )))
            ->add('info_site_url', null, array(
                'label' => 'URL/Adresse du site (www.monsite.fr)',
                'attr' => array(
                    'value' => $options['parameters']['info_site_url']
                )))
            ->add('presentation', TextareaType::class, array(
                'label' => 'Présentation du serveur (recommandé)',
                'required' => false,
                'data' => $options['parameters']['presentation'],
                'attr' => array(

                )
            ))
            ->add('info_logo', FileType::class, array(
                'label' => 'Upload logo du serveur',
                'required' => false,
                'attr' => array(
                    //'class' => 'dropzone'
                )
            ))
            ->add('info_favicon', FileType::class, array(
                'label' => 'Upload favicon (logo de l\'onglet)',
                'required' => false,
                'attr' => array(
                    //'class' => 'dropzone'
                )
            ))
            ->add('info_banner', FileType::class, array(
                'label' => 'Upload bannière',
                'required' => false,
                'attr' => array(
                    //'class' => 'dropzone'
                )
            ))
            ->add('server_ip', null, array(
                'label' => 'IP du serveur',
                'attr' => array(
                    'value' => $options['parameters']['server_ip']
                )))
            ->add('server_port', NumberType::class, array(
                'label' => 'Port du serveur',
                'attr' => array(
                    'value' => $options['parameters']['server_port']
                )))
            ->add('email_contact', EmailType::class, array(
                'label' => 'email de contact',
                'attr' => array(
                    'value' => $options['parameters']['email_contact']
                )))
            ->add('Submit', SubmitType::class, array(
                'attr' => array(
                    'class' => 'button-green'
            )))
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'parameters' => array()
        ));
    }
}