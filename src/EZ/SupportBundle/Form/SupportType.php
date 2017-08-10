<?php

namespace EZ\SupportBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class SupportType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categorie', ChoiceType::class, array(
                'placeholder' => 'De quel type est votre requête ?',
                'choices' => array(
                    'Question' => 1,
                    'Autres' => 2,
                    'Siganelement d\'un joueur' => 3
                )
            ))
            ->add('priority', ChoiceType::class, array(
                'placeholder' => 'Priorité de votre requête',
                'choices' => array(
                    'Basse' => '4',
                    'Moyenne' => '3',
                    'Haute' => '2',
                    'Très haute' => '1'
                ),
                'label' => 'Priorité',
                'required' => false
            ))
            ->add('Priority', TextType::class, array(
                'attr' => array('placeholder' => 'Pseudo du joueur', 'style' => 'display:none;'),
                'label' => false,
                'required' => false
            ))

            ->add('message', TextareaType::class, array(
                'attr' => array('placeholder' => 'Votre question/message')
            ))
            ->add('button', ButtonType::class, array(
                'label' => 'Envoyer',
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EZ\SupportBundle\Entity\Support'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ez_supportbundle_support';
    }


}
