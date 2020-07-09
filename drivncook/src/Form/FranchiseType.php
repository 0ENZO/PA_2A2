<?php

namespace App\Form;

use App\Entity\Franchise;
use App\Entity\Address;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
// use Symfony\Component\Mime\Address;
use Vich\UploaderBundle\Form\Type\VichImageType;

class FranchiseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('email', EmailType::class)
            ->add('phoneNumber', TextType::class)
            ->add('Address', EntityType::class, [
                'class' => Address::class,
                'label' => 'Adresse :'
            ])
            ->add('password')
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'download_uri' => true,
                'image_uri' => true,
                'asset_helper' => true,
                'download_label' => false,
                'delete_label' => false,
                "allow_delete" => false,
            ])
            // ->add('birthDate', DateType::class)
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer'
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Franchise::class,
        ]);
    }
}
