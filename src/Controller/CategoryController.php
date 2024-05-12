<?php

namespace App\Controller;
use App\Entity\Category; 
use App\Form\CategoryFormType;
use App\Repository\CategoryRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(CategoryRepository $CategoryRepository): Response
    {
        $categories = $CategoryRepository->findAll();
        
        return $this->render('category/index.html.twig', [
            'categories'=>$categories
        ]);
    }
    #[Route('category/new', name: 'app_category_new')]
    public function addCategory(EntityManagerInterface $entityManger,Request $resuest): Response
    {   
        $category = new Category();
        $form = $this -> createForm(CategoryFormType::class,$category);
        $form->handleRequest($resuest);
        if($form->isSubmitted() && $form->isValid()){
            $entityManger->persist($category);
            $entityManger->flush();
            return $this->redirectToRoute('app_category');
        }
        return $this->render('category/new.html.twig',['form'=>$form->createView()]);
    } 
    #[Route('/category/{id}/update',name:'app_category_update')]
    public function update(Category $category ,EntityManagerInterface $entityManger,Request $resuest):response{
        $form = $this -> createForm(CategoryFormType::class,$category);
        $form->handleRequest($resuest);
        if($form->isSubmitted() && $form->isValid()){
            $entityManger->persist($category);
            $entityManger->flush();
            return $this->redirectToRoute('app_category');
        }
        return $this->render('category/update.html.twig',['form'=>$form->createView()]);
    }
    #[Route('/category/{id}/delete',name:'app_category_delete')]
    public function delete(Category $category ,EntityManagerInterface $entityManger,Request $resuest):response{
        
        $entityManger->remove($category);
        $entityManger->flush();
        return $this->redirectToRoute('app_category');

    }
}