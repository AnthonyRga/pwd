<?php

namespace App\Controller;

use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    // function qui permet à un anonyme de s'inscrire
    /**
     * @Route("/inscription", name="security-registration")
     */

    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder){

        // je crée un nouveau user
        $user = new User();
        // j'ai besoin d'un form d'inscription
        $form = $this->createForm(RegistrationType::class, $user);
        // le form gère la requête
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            // on crypte son mot de passe
            $hash = $encoder->encodePassword($user, $user->getPassword());
            // on attribue à l'user son rôle d'user
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();
            // lorsque l'user a rempli et validé la form, il est redirigé vers le login de connexion
            return $this->redirectToRoute('security-login');
        }
        // on affiche le tout
        return $this->render("security/registration.html.twig", [
            'form' => $form->createView()
        ]);
    }

    // page login
    /**
     * @Route("/connexion", name="security-login")
     */

    public function login(){

        return $this->render('security/login.html.twig');
    }

    // function pour se déconnecter
    /**
     * @Route("/deconnexion", name="security-logout")
     */
    public function logout(){

    }
}
