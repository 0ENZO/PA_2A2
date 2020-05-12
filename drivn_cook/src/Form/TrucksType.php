<?php

namespace App\Form;

use App\Entity\Trucks;
use App\Entity\Franchises;
use App\Entity\MaxCapacities;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TrucksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idFranchise', EntityType::class, [
                'class' => Franchises::class,
                'label' => 'Franchisé',
                'required' => false
            ])
            ->add('idMaxCapacity', EntityType::class, [
                'class' => MaxCapacities::class,
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
            'data_class' => Trucks::class,
        ]);
    }
}
