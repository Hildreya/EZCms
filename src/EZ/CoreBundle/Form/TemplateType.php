<?php
namespace EZ\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TemplateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('theme', FileType::class, array('label' => 'Nouveau theme (fichier zip)'))
            ->add('save', SubmitType::class, array('label' => 'Upload'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
    }
}