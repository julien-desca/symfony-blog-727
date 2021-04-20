<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController{

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    public function __construct(EntityManagerInterface $manager, ArticleRepository $articleRepository)
    {
        $this->manager = $manager;
        $this->articleRepository = $articleRepository;
    }

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
            $this->manager->persist($article);
            $this->manager->flush();
            return $this->redirectToRoute('list_article');
        }

        return $this->render('articles/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/articles", name="list_article")
     */
    public function listArticle(Request $request){
        $articleList = $this->articleRepository->findAll();
        return $this->render('articles/list.html.twig', ['articleList' => $articleList]);
    }

    /**
     * @Route("/articles/{id}", name="get_article", requirements={"id"="\d+"})
     */
    public function getArticle(Request $request, int $id){
        $article = $this->articleRepository->find($id);
        if($article == null){
            throw new HttpException(404, "Article not found");
        }
        return $this->render("articles/detail.html.twig", ['article'=>$article]);
    }

    /**
     * @Route("/articles/delete/{id}", name="delete_article", requirements={"id"="\d+"})
     */
    public function deleteArticle(Request $request, int $id){
        $article = $this->articleRepository->find($id);
        
        $this->manager->remove($article);
        $this->manager->flush();
        
        return $this->redirectToRoute('list_article');
    }
}

