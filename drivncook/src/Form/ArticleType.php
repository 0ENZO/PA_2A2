<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArticleType extends AbstractType
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
            ->add('price')
            ->add('vat')
            ->add('subCategory')
            ->add('recipes', CollectionType::class, [
                "entry_type" => RecipeType::class,
                "allow_add" => true,      // Permet de créer un attribut html "prototype" contenant le code html vierge de du formulaire RecipeType
                "allow_delete" => true,   // Permet la suppression d'objet lié à article en cas de besoin (dans le formulaire d'édition par exmlp)
                "delete_empty" => true,
            ])
            ->add('status', ChoiceType::class, [
                "choices" => [
                    "Disponible" => "Disponible",
                    "Indisponible" => "Indisponible",
                    "En cours de vérifications" => "Vérification"
                ]
            ])
            ->add('euroPointsGap')
            ->add('formulePointsGap')
            ->add('save', SubmitType::class, [
                "label" => "Enregistrer"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
