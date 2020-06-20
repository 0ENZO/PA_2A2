<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'download_uri' => true,
                'image_uri' => true,
                'asset_helper' => true,
                'download_label' => false,
                'delete_label' => false,
                "allow_delete" => false,
            ])
            ->add('price', MoneyType::class, [
                "label" => "Prix HT"
            ])
            ->add('status', ChoiceType::class, [
                "choices" => [
                    "Disponible" => "Disponible",
                    "Indisponible" => "Indisponible"
                ]
            ])
            ->add('expiryDate')
            ->add('quantity')
            ->add('subCategory')
            ->add("save", SubmitType::class, [
                "label" => "Enregistrer"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
