<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ArticlesController extends AbstractController
{

    // function qui affiche les articles en fonction de leur id
    /**
     * @Route("/article/{id}", name="article-id")
     */
    public function show($id, Request $request, ObjectManager $manager)
    {
        // j'utilise le repository des articles et je trouve l'id
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);
        // je prends le magasin correspondant à l'article
        $stores = $articles->getStore();
        // je prends l'user
        $user = $this->getUser();
        // création d'un commentaire
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            // le commentaire est lié à l'article
            $comment->setArticle($articles);
            // le commentaire est lié à l'user
            $comment->setUser($user);
            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('article-id', ['id' => $articles->getId()]);
        }
        // si pas d'articles, donne une erreur
        if (!$articles) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
        // affichage de mes entités et le form commentaire avec le twig
        return $this->render('inc/article-view.html.twig', [
            'articles' => $articles,
            'stores' => $stores,
            'user' => $user,
            'commentForm' => $form->createView()
        ]);
    }

}