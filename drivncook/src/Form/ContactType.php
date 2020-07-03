<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'constraints' => new Length(['min' => 3]),
                'label' => 'Prénom',
                'required' => true
            ])
            ->add('lastName', TextType::class, [
                'constraints' => new Length(['min' => 3]),
                'label' => 'Nom',
                'required' => true
            ])
            ->add('phone', TextType::class, [
                'constraints' => new Length(['min' => 10]),
                'label' => 'Téléphone',
                'required' => true
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => true
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Votre message',
                'required' => true
            ])
        ;
    }
}
