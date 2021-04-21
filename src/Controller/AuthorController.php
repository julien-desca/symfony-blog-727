<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController {

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var AuthorRepository
     */
    private $authorRepository;

    public function __construct(EntityManagerInterface $manager, AuthorRepository $authorRepository)
    {
        $this->manager = $manager;
        $this->authorRepository = $authorRepository;
    }

    /**
     * @Route("/authors/create", name="create_author")
     */
    public function createAuthor(Request $request){
        $author = new Author();

        $builder = $this->createFormBuilder($author);
        $form = $builder->add('firstName', TextType::class, ['label' => 'Prénom'])
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
            return $this->redirectToRoute('list_author');
        }
        return $this->render('authors/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/authors", name="list_author")
     */
    public function listAuthor(Request $request){
        $authorList = $this->authorRepository->findAll();
        return $this->render('authors/list.html.twig', ['authorList' => $authorList]);
    }

    /**
     * @Route("/authors/{id}", name="get_author", requirements={"id"="\d+"})
     */
    public function getAuthor(Request $request, int $id){
        $author = $this->authorRepository->find($id);
        if($author == null){
            throw new HttpException(404);
        }
        return $this->render('authors/detail.html.twig', ['author'=>$author]);
    }

    /**
     * @Route("/authors/delete/{id}", name="delete_author", requirements={"id"="\d+"})
     */
    public function deleteAuthor(Request $request, int $id){
        $author = $this->authorRepository->find($id);

        $this->manager->remove($author);
        $this->manager->flush();

        return $this->redirectToRoute('list_author');
    }
}