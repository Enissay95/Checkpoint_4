<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Form\AdminType;
use App\Entity\User;
use App\Entity\Article;
use App\Repository\ArticleRepository;

#[Route('/user', name: 'user_')]
class UserController extends AbstractController
{
    #[Route('/account', name: 'account')]
    public function account(UserRepository $userRepository, ArticleRepository $articleRepository): Response
    {


        //$admin = $userRepository->findAll();
        $user = $this->getUser();
        $articles = $articleRepository->findByUser('ROLE_USER');//$this->getUser()->getArticle();dd($articles);
        return $this->render('user/account.html.twig', [
            'user' => $user,
            'articles' => $articles,
        ]);
    }

    #[Route('/{id}/edit/', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {


        $form = $this->createForm(AdminType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);

            return $this->redirectToRoute('user_account', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
