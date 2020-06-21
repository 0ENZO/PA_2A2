<?php

namespace App\Form;

use App\Entity\Truck;
use App\Entity\Franchise;
use App\Entity\MaxCapacity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TruckType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Franchise', EntityType::class, [
                'class' => Franchise::class,
                'label' => 'Franchisé',
                'required' => false
            ])
            ->add('MaxCapacity', EntityType::class, [
                'class' => MaxCapacity::class,
                'label' => 'Capacité max (Ingrédients, Boissons, Desserts, Plats)',
                'required' => false
            ])
            ->add('brand', TextType::class)
            ->add('model', TextType::class)
            ->add('status', IntegerType::class)
            ->add('factoryDate', DateType::class)
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer'
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Truck::class,
        ]);
    }
}
