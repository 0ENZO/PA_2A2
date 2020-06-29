<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\ReportBreakdown;
use App\Entity\AnswerReportBreakdown;
use App\Repository\AnswerReportBreakdownRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AnswerReportBreakdownType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reportBreakdown', EntityType::class, [
                'class' => ReportBreakdown::class,
                'label' => 'Panne',
                'required' => true
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'label' => 'Technicien',
                'required' => true
            ])
            ->add('content', TextType::class)
            ->add('date', DateType::class)
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer'
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AnswerReportBreakdown::class,
        ]);
    }
}
