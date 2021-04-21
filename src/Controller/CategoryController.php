<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController{

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(EntityManagerInterface $manager, CategoryRepository $categoryRepository)
    {
        $this->manager = $manager;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route("/categories/create", name="create_category")
     */
    public function createCategory(Request $request){
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->manager->persist($category);
            $this->manager->flush();
            return $this->redirectToRoute('list_category');
        }

        return $this->render('categories/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/categories", name="list_category")
     */
    public function listCategory(Request $request){
        $categoriesList = $this->categoryRepository->findAll();
        return $this->render('categories/list.html.twig', ['categoriesList' => $categoriesList]);
    }

    /**
     * @Route("/categories/update/{id}", name="update_category", requirements={"id"="\d+"})
     */
    public function updateCategory(Request $request, int $id){
        $category = $this->categoryRepository->find($id);
        if($category == null){
            throw new HttpException(404);
        }

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $this->manager->persist($category);
            $this->manager->flush();
            return $this->redirectToRoute('list_category');
        }

        return $this->render('categories/update.html.twig', ['form'=>$form->createView()]);
    }

    /**
     * @Route("/categories/delete/{id}", name="delete_category", requirements={"id"="\d+"})
     */
    public function deleteCategory(Request $request, int $id){
        $category = $this->categoryRepository->find($id);
        $this->manager->remove($category);
        $this->manager->flush();

        return $this->redirectToRoute('list_category');
    }
}