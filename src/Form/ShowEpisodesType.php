<?php

namespace App\Form;

use App\Entity\ShowEpisodes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ShowEpisodesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rating', null, array(
                'attr' => array('min' => 0, 'max' => '5', 'autofocus' => null)
            ))
            
            // ->add('title', TextType::class, array(
            //     'attr' => array(
            //         'readonly' => true,
            //     ),
            // ))
            // ->add('filepath', TextType::class, array(
            //     'attr' => array(
            //         'readonly' => true,
            //     ),
            // ))
            // ->add('season', IntegerType::class, array(
            //     'attr' => array(
            //         'readonly' => true,
            //     ),
            // ))
            // ->add('episode', IntegerType::class, array(
            //     'attr' => array(
            //         'readonly' => true,
            //     ),
            // ))
            // ->add('category', TextType::class, array(
            //     'attr' => array(
            //         'readonly' => true,
            //     ),
            // ))
            // ->add('format', TextType::class, array(
            //     'attr' => array(
            //         'readonly' => true,
            //     ),
            // ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ShowEpisodes::class,
            'csrf_protection' => true,
        ]);
    }
}
