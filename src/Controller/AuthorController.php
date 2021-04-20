<?php

namespace App\Controller;

use App\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController {

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/authors/create", name="create_author")
     */
    public function createAuthor(Request $request){
        $author = new Author();

        $form = $this->createFormBuilder($author)
            ->add('firstName', TextType::class, ['label' => 'Prénom'])
            ->add('lastName', TextType::class, ['label' => 'Nom'])
            ->add('email', EmailType::class, [
                'label' => 'Adresse e-mail',
                'required' => false,
            ])
            ->add('birthDate', BirthdayType::class, [
                'label' => 'Date de naissance',
                'required' => false,
            ])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
            ->getForm();
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->manager->persist($author);
            $this->manager->flush();
            return new Response("Auteur créé");
        }
        return $this->render('authors/create.html.twig', ['form' => $form->createView()]);
    }
}