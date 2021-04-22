<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CommentType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('authorName', TextType::class, ['label' => 'Entrez votre nom'])
        ->add('content', TextareaType::class, ['label' => 'Votre commentaire'])
        ->add('save', SubmitType::class, ['label' => 'Enregistrer']);
    }
}