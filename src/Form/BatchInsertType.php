<?php

namespace App\Form;

use App\Repository\ShowEpisodesRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class BatchInsertType extends AbstractType 
{
    

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('show', ChoiceType::class, [
                'choices' => [
                    'Rick and Morty' => 1,
                    'South Park' => 2,
                    'Adventure Time' => 3,
                    'SpongeBob SquarePants' => 1,
                ]
            ])
            ->add('season', IntegerType::class)
            ->add('file', FileType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            
        ]);
    }
}