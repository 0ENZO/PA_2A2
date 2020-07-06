<?php

namespace App\Form;

use App\Entity\BreakdownType;
use App\Entity\Truck;
use App\Entity\Breakdown;
use App\Entity\Franchise;
use App\Entity\MaxCapacity;
use App\Entity\ReportBreakdown;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ReportBreakdownType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('truck', EntityType::class, [
                'class' => Truck::class,
                'label' => 'Camion',
                'required' => false
            ])
            ->add('breakdown', EntityType::class, [
                'class' => Breakdown::class,
                'label' => 'Panne',
                'required' => false
            ])
            ->add('description', TextType::class)
            ->add('date', DateType::class)
            ->add('phoneNumber')
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'download_uri' => true,
                'image_uri' => true,
                'asset_helper' => true,
                'download_label' => false,
                'delete_label' => false,
                "allow_delete" => false,
            ])
            ->add('status')
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer'
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ReportBreakdown::class,
        ]);
    }
}
