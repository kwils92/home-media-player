<?php

namespace App\Form;

use App\Entity\Shows; 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class BatchInsertType extends AbstractType 
{
    

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('show', EntityType::class, [
                'class' => Shows::class,
                'choice_label' => str_replace('_', ' ', 'title'),
            ])
            ->add('season', IntegerType::class, array(
                'attr' => array('min' => 0)
            ))
            ->add('file', FileType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

        ]);
    }
}