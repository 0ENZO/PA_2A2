<?php

namespace App\Form;

use App\Entity\Recipe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity')
            ->add('product')
            ->add('type', ChoiceType::class, [
                "choices" => [
                    "Unité (Unit)" => "Unit",
                    "g (Gramme)" => "g",
                    "Kg (Kilogramme)" => "Kg",
                    "cl (Centilitre)" => "cl",
                    "L (Litre)" => "L"
                ],
                "label" => "Unité"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
