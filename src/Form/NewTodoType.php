<?php

namespace App\Form;

use App\Entity\Todo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class NewTodoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('attr' => 
            array('class' => 'form-control')))
            ->add('description', TextareaType::class, array('attr' =>
            array('class' => 'form-control')))
            ->add('duedate', DateType::class, array('attr' =>
            array('class' => 'form-control')))
            ->add('save', SubmitType::class, array(
                'label' => 'Add',
                'attr' => array('class' => 'btn btn-primary mt-3')
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Todo::class,
        ]);
    }
}
