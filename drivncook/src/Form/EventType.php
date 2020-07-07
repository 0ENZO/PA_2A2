<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Address;
use App\Entity\Franchise;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('dateBegin', DateType::class)
            ->add('dateEnd', DateType::class)
            ->add('price', IntegerType::class)
           ->add('address', EntityType::class, [
              'class' => Address::class,
              'label' => 'Adresse :'
          ])
            ->add('franchise', EntityType::class, [
                'class' => Franchise::class,
                'label' => 'Franchisé',
                'multiple'  => true
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'download_uri' => true,
                'image_uri' => true,
                'asset_helper' => true,
                'download_label' => false,
                'delete_label' => false,
                "allow_delete" => false,
            ])
//            ->add('save', SubmitType::class, [
//                "label" => 'Enregistrer'
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
