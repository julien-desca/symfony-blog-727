<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ArticleType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('title', TextType::class, ['label'=>'Titre'])
                ->add('content', TextareaType::class, ['label'=>'Contenu de l\'article'])
                ->add('author', EntityType::class, [
                    'label'=>'Auteur de l\'article',
                    'class' => Author::class,
                    'choice_label' => function($author){
                        return $author->getFirstName() . " " . $author->getLastName();
                    },
                ])
                ->add('categories', EntityType::class, [
                    'label' => 'Categorie de l\'article',
                    'class' => Category::class,
                    'choice_label' => 'name',
                    'multiple' => true,
                    'expanded' => true,
                ])
                ->add('save', SubmitType::class, ['label' => 'Enregister']);
    }
}