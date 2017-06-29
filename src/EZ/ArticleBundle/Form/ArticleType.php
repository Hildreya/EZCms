<?php

namespace EZ\ArticleBundle\Form;

use Doctrine\DBAL\Types\DateType;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ArticleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', \Symfony\Component\Form\Extension\Core\Type\TextType::class, array(
            'label' => 'Titre'
        ))
            ->add('content', TextareaType::class, array(
                'label' => 'Contenu'
            ))
            ->add('creationDate', DateType::class, array(
                'label' => 'Date de création'
            ))
            ->add('modificationDate', DateType::class, array(
                'label' => 'Date de modification'
            ))
            ->add('author', TextType::class, array(
                'label' => 'Auteur'
            ))
            ->add('comment', CommentType::class, array(
                'label' => 'Commentaires'
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Sauvegarder',
                'attr' => array('class' => 'button-green')
            ));

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EZ\ArticleBundle\Entity\Article'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ez_articlebundle_article';
    }


}
