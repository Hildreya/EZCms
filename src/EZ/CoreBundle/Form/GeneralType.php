<?php
namespace EZ\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class GeneralType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('server_name', null, array(
                'attr' => array(
                    'value' => $options['data']['parameters']['server_name']
                )))
            ->add('info_site_url', null, array(
                'attr' => array(
                    'value' => $options['data']['parameters']['info_site_url']
                )))
            ->add('info_banner')
            ->add('info_favicon')
            ->add('info_logo')
            ->add('server_ip', null, array(
                'attr' => array(
                    'value' => $options['data']['parameters']['server_ip']
                )))
            ->add('server_port', NumberType::class, array(
                'attr' => array(
                    'value' => $options['data']['parameters']['server_port']
                )))
            ->add('email_contact', EmailType::class)
            ->add('Submit', SubmitType::class)
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
    }
}