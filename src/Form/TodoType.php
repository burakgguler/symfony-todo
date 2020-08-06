<?php

namespace App\Form;

use App\Entity\Todo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class TodoType extends AbstractType
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
            
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event){
                $todo = $event->getData();
                $form = $event->getForm();

                if(null != $todo->getId()){

                
                if($todo->getCompleted()){
                    $form->add('completed', CheckboxType::class, array(
                        'label'    => 'Uncheck it if task is not completed yet!',
                        'required' => false,
                    ));
                }
                else{
                    $form->add('completed', CheckboxType::class, array(
                        'label'    => 'Check it if task is completed!',
                        'required' => false,
                    ));
                }
            }
            })

            ->add('file',FileType::class, array(
                'label' => 'Upload files!',
                'mapped' => false,
                'required' => false
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
