<?php

namespace App\Form;

use App\Entity\Events;
use App\Entity\Franchises;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                 'attr' =>[
                      'class' => 'btn btn-danger'
                      ]
            ])
            ->add('description', TextType::class)
            ->add('dateBegin', DateType::class)
            ->add('dateEnd', DateType::class)
            ->add('price', IntegerType::class)
            ->add('idFranchise', EntityType::class, [
                'class' => Franchises::class,
                'label' => 'Franchisé',
                #'mapped' => false
            ])
           ->add('save', SubmitType::class, [
                'label' => 'Enregistrer'
            ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Events::class,
        ]);
    }
}
