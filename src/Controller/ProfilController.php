<?php

namespace App\Controller;


use App\Entity\Article;
use App\Entity\User;
use App\Entity\Comment;
use App\Form\EditProfilType;
use App\Form\EditPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class ProfilController extends AbstractController
{

    // page profil en fonction de l'id du user
    /**
     * Page profil
     * @Route("/profil/{id}", name="user-id")
     */
    public function profil($id)
    {
        // je trouve les users en fonction de leur id
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);
        // je prends les commentaires du user
        $comment = $this->getUser();

        // je trouve les articles en fonction de leur id
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);

        // j'affiche le tout
        return $this->render('inc/profil.html.twig', [
            'user' => $user,
            'comment' => $comment,
            'articles'=> $articles
        ]);
    }

    // function qui permet à l'user d'éditer son profil
    /**
     * @Route("profil/edit/{id}", name="editProfil", methods={"GET","POST"})
     */
    public function editProfil($id, User $user, Request $request, EntityManagerInterface $em)
    {
        // je trouve les users en fonction de leur id
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);
        $form = $this->createForm(EditProfilType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();
            // après modification l'user retourne automatiquement sur son profil
            return $this->redirectToRoute('user-id', ['id' => $user->getId()]);
        }

        return $this->render('/security/editProfil.html.twig', ['user' => $user, 'form' => $form->createView()]);
    }

    // function qui permet à l'user d'éditer son mot de passe
    /**
     * @Route("profil/edit-password/{id}", name="editPassword", methods={"GET","POST"})
     */
    public function editPassword($id, User $user, Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        // je trouve les users en fonction de leur id
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);
        $form = $this->createForm(EditPasswordType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // encoder = protéger mot de passe en le changeant avec un algorithm
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user-id', ['id' => $user->getId()]);
        }

        return $this->render('/security/editPassword.html.twig', ['user' => $user, 'form' => $form->createView()]);
    }

}