<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController{

    /**
     * @Route("/articles/create", name="create_article")
     */
    public function createArticle(Request $request){
        $article = new Article();

        $form = $this->createFormBuilder($article)
                    ->add('title', TextType::class, ['label'=>'Titre'])
                    ->add('content', TextareaType::class, ['label'=>'Contenu de l\'article'])
                    ->add('save', SubmitType::class, ['label' => 'Enregister'])
                    ->getForm();

        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            //faire l'enregistrement en BDD
            dump($article);
        }

        return $this->render('articles/create.html.twig', ['form' => $form->createView()]);
    }
}