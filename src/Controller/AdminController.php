<?php

namespace App\Controller\front\Buyer;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\AdminType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/Admin', name: 'admin_')]
class AdminController extends AbstractController
{
    #[Route('/account', name: 'account')]
    public function account(UserRepository $userRepository): Response
    {


        //$admin = $userRepository->findAll();
        $admin = $this->getUser();
        return $this->render('admin/account.html.twig', [
            'admin' => $admin,
        ]);
    }

    #[Route('/{id}/edit/', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {


        $form = $this->createForm(AdminType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);

            return $this->redirectToRoute('admin_account', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/admin/edit.html.twig', [
            'admin' => $user,
            'form' => $form,
        ]);
    }
}
