<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\SubCategories;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class SubCategoriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add("fileName")
            ->add('image', VichImageType::class, [
                'required' => false,
                'download_uri' => true,
                'image_uri' => true,
                'asset_helper' => true,
                'download_label' => false,
            ])
            ->add('idCategory', EntityType::class, [
                "class" => Categories::class,
                "label" => "Catégorie"
            ])
            ->add("save", SubmitType::class, [
                "label" => "Enregistrer"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SubCategories::class,
        ]);
    }
}
