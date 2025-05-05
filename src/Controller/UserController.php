<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserPiloteType;
use App\Form\UserType;
use App\Form\UserVolType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;


final class UserController extends AbstractController
{
    #[Route('/user',name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository ): Response
    {

        if(!$this->isGranted('ROLE_USER')&& !$this->isGranted('ROLE_PILOTE')
            && !$this->isGranted('ROLE_VOL') && !$this->isGranted('ROLE_ADMIN') ){
            return $this->render('index.html.twig', [
                'show_modal' => 'userConnexion',
            ]);
        }


        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll() ,
            'show_modal'=>false] );
    }


    #[Route('/user/new', name: 'app_compteUser_new', methods: ['GET', 'POST'])]
    public function newCompteUser(Request $request,EntityManagerInterface $entityManager , UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mdpHash = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($mdpHash);
            $user -> setRoles(['ROLE_USER']);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
    #[Route('/userPilote/new', name: 'app_comptePilote_new', methods: ['GET', 'POST'])]
    public function newComptePilote(Request $request,EntityManagerInterface $entityManager , UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserPiloteType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mdpHash = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($mdpHash);
            $user -> setRoles(['ROLE_PILOTE']);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
    #[Route('/userVol/new', name: 'app_compteVol_new', methods: ['GET', 'POST'])]
    public function newCompteVol(Request $request,EntityManagerInterface $entityManager , UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserVolType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mdpHash = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($mdpHash);
            $user -> setRoles(['ROLE_VOL']);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/user/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/user/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserPiloteType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/user/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/indexInscription', name: 'app_index_inscription', methods: ['GET'])]
    public function indexInscription(): Response{
        return $this->render('user/indexInscription.html.twig');
    }
}
