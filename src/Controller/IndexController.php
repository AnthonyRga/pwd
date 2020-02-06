<?php

namespace App\Controller;


use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class IndexController extends AbstractController
{

    // route index - j'affiche tous mes articles
    /**
     * @Route("/",name="home" )
     */
    public function home(ArticleRepository $ArticleRepository): Response
    {
        // j'appelle le repository des articles et je les trouve tous
        $articles = $ArticleRepository->findAll();

        // j'affiche tous mes articles
        return $this->render('inc/postList.html.twig', [
            'articles' => $articles,
        ]);
    }

}
