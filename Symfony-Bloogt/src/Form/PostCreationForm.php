<?php


namespace App\Form;



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostCreationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
    //        ->add('title', TextType::class, ['help' => 'Enter your Message'])
            ->add('content', TextareaType::class, ['help' => 'Enter your Message'])

            ->add('category', \Symfony\Bridge\Doctrine\Form\Type\EntityType::class, array(
                // query choices from this entity
                'class' => 'App\Entity\Category',
                'choice_label' => 'name',
            ))
/*
            ->add('category', ChoiceType::class, [

                'choices'  => [
                    'Health' => 'Health',
                    'Science' => 'Science',
                    'QuickPost' => 'QuickPost',
                ],
            ])*/
            ;


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_field_name' => '_token',
        ]);
    }
}