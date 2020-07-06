<?php

namespace App\Form;

use App\Entity\MaxCapacity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaxCapacityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('maxIngredients')
            ->add('maxDrinks')
            ->add('maxDesserts')
            ->add('maxMeals')
            ->add("save", SubmitType::class, [
                "label" => "Enregistrer"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MaxCapacity::class,
        ]);
    }
}
