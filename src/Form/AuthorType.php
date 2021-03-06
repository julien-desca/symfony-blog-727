<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class AuthorType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, ['label' => 'Prénom'])
            ->add('lastName', TextType::class, ['label' => 'nom'])
            ->add('email', EmailType::class, [
                'label' => 'adresse e-mail',
                'required' => false,
            ])
            ->add('birthDate', BirthdayType::class, [
                'label' => 'Date de naissance',
                'required' => false,
            ])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer']);
    }
}