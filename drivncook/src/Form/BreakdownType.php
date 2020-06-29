<?php

namespace App\Form;

use App\Entity\Breakdown;
use App\Entity\BreakdownType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BreakdownsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('statement')
            ->add('breakdownType', EntityType::class, [
                'class' => BreakdownType::class,
                'label' => 'Type de panne',
                'required' => true
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer'
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Breakdown::class,
        ]);
    }
}
