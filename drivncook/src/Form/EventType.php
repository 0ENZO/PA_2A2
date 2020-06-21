<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Franchise;
use App\Entity\Address;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('dateBegin', DateType::class)
            ->add('dateEnd', DateType::class)
            ->add('price', IntegerType::class)
           # ->add('imageName')
           ->add('Address', EntityType::class, [
              'class' => Address::class,
              'label' => 'Adresse :'
          ])
            ->add('franchise', EntityType::class, [
                'class' => Franchise::class,
                'label' => 'Franchisé',
                'multiple'  => true
            ])
            ->add('save', SubmitType::class, [
                  'label' => 'Enregistrer'
              ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
