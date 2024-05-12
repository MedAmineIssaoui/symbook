<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/admin/user', name: 'app_user')]
    public function index( UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users'=>$userRepository->findAll(),
            
        ]);
    }
    #[Route('/admin/user/{id}/yo/editor', name: 'app_user_to_editor')]
    public function changeRole(EntityManagerInterface $entityManger,user $user): Response
    {
        $user->setRoles(['ROLE_ADMIN','ROLE_USER']);
        $entityManger->flush();
        // $this->addFlash('success','le role editeur a été ajoute à votre utilisateur');
        return $this->redirectToRoute('app_user');
    }  
}
