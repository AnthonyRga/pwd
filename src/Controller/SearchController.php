<?php

namespace App\Controller;

use App\Form\ArticleSearchType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    // function qui permet d'effectuer une recherche de mes articles
    // en utilisant des critères
    // et le repository de mes articles (voir celui ci pour le querybuilder)
    /**
     * @Route("/article-search", name="search-article")
     */

    public function articleSearch(Request $request, ArticleRepository $articleRepository)
    {
        $articles = [];
        $search = $this->createForm(ArticleSearchType::class);

        if($search->handleRequest($request)->isSubmitted() && $search->isValid()) {
            $criteria = $search->getData();
            $articles = $articleRepository->ArticleSearch($criteria);
        }

        return $this->render('inc/search-bar.html.twig', [
            'articles' => $articles,
            'search_form' => $search->createView()
        ]);
    }

}