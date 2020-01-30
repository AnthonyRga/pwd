<?php


namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Article;
use App\Entity\Store;
use App\Entity\User;
use App\Form\ArticleEditType;
use App\Form\ArticleImageEditType;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Form\StoreType;
use App\Repository\UserRepository;
use App\Repository\CommentRepository;
use App\Repository\StoreRepository;
use App\Repository\ArticleRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;





class AdminController extends AbstractController
{


    // function qui interdit les autres rôles d'avoir accès à la partie admin
    public function adminAcces()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
    }

    // page index de l'admin
    /**
     * Page admin
     * @Route("/admin", name="admin")
     * @IsGranted("ROLE_ADMIN")
     */
    public function admin()
    {
        return $this->render('admin/admin.html.twig');
    }

    // page admin qui liste les articles
    /**
     * Page list article admin
     * @Route("/admin/list-articles", name="list-articles")
     * @IsGranted("ROLE_ADMIN")
     */
    public function articleListAdmin(ArticleRepository $ArticleRepository)
    {
        // j'appelle tous les articles via le repository des Articles
        $articles = $ArticleRepository->findAll();

        // je les affiche tous
        return $this->render('admin/postListAdmin.html.twig', [
            'articles' => $articles
        ]);
    }

    // page admin qui liste les magasins
    /**
     * Page list store admin
     * @Route("/admin/list-store", name="list-store")
     * @IsGranted("ROLE_ADMIN")
     */
    public function storeListAdmin(StoreRepository $StoreRepository)
    {
        // j'appelle tous les magasins via le repository des Magasins
        $store = $StoreRepository->findAll();

        // je les affiche tous
        return $this->render('admin/storeListAdmin.html.twig', [
            'stores' => $store
        ]);
    }

    // function qui permet de supprimer les commentaires
    /**
     * @Route("/admin/comments/{id}", name="removeComment", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function removeComment(Comment $comment, EntityManagerInterface $em): RedirectResponse
    {
        $em->remove($comment);
        $em->flush();

        return $this->redirectToRoute("comments");
    }

    // function qui permet de supprimer les articles
    /**
     * @Route("/admin/article/{id}", name="removeArticle", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function removeArticle(Article $article, EntityManagerInterface $em): RedirectResponse
    {
        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute("list-articles");
    }

    // affichage des membres du site
    /**
     * Page liste membres
     * @Route("/admin/members", name="members")
     * @IsGranted("ROLE_ADMIN")
     */
    public function adminMembers(UserRepository $UserRepository)
    {
        // j'appelle tous les users dans l'userRepository
        $users = $UserRepository->findAll();

        // je les affiche
        return $this->render('admin/members.html.twig', ['users' => $users]);
    }

    // function pour supprimer un user
    /**
     * @Route("/admin/user/{id}", name="removeUser", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function removeUser(User $user, EntityManagerInterface $em): RedirectResponse
    {
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute("members");
    }

    // function pour ajouter un article
    /**
     * @Route("/admin/add")
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request)
    {
        //je veux créer un article
        $article = new Article();
        // j'ai besoin d'un form pour le créer
        $form = $this->createForm(ArticleType::class, $article);
        // le form gère la request
        $form->handleRequest($request);
        // si les infos données au form sont ok
        if ($form->isSubmitted() && $form->isValid()) {
            // upload image
            $file = $article->getImage();
            // uniqid pour changer le nom de l'image et éviter d'avoir le même nom
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            // positionner l'image dans un dossier
            try{
                $file->move(
                    $this->getParameter('uploads_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                //
            }
            $em = $this->getDoctrine()->getManager();
            $article->setImage($fileName);
            $em->persist($article);
            $em->flush();

            return $this->RedirectToRoute('admin');
        }

        return $this->render('admin/add.html.twig', array(
            // la vue du form
            'form' => $form->createView(),
        ));
    }

    // function ajouter un nouveau magasin
    /**
     * @Route("/admin/add-store")
     * @IsGranted("ROLE_ADMIN")
     */
    public function newStore(Request $request)
    {
        // je veux créer un magasin
        $store = new Store();
        // j'ai besoin d'un form
        $form = $this->createForm(StoreType::class, $store);
        // le form gère la request
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($store);
            $em->flush();

            return $this->RedirectToRoute('admin');
        }

        return $this->render('admin/add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    // function qui edit un article
    /**
     * @Route("/pwd/admin/edit/{id}", name="editBlogPost", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function editArticles(Article $article, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ArticleEditType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('list-articles');

        }

        return $this->render('admin/add.html.twig', ['form' => $form->createView()]);
    }

    // function qui edit une image d'un article
    /**
     * @Route("/pwd/admin/edit-image/{id}", name="editImage", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function editImage(Article $article, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ArticleImageEditType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('list-articles');

        }

        return $this->render('admin/add.html.twig', ['form' => $form->createView()]);
    }

    // function qui edit un magasin existant
    /**
     * @Route("/pwd/admin/edit-store/{id}", name="edit-store", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function editStore(Store $store, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(StoreType::class, $store);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($store);
            $em->flush();
            return $this->redirectToRoute('list-store');


        }

        return $this->render('/admin/add.html.twig', ['form' => $form->createView()]);
    }

    // function qui permet à l'user connecter de modifier ses commentaires
    /**
     * @Route("/pwd/user/edit-com/{id}", name="editComment", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function editComment($id, Comment $comment, Request $request, EntityManagerInterface $em)

    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('/admin/edit-comment.html.twig', ['user' => $user, 'form' => $form->createView()]);
    }

    // function qui permet à l'user connecter de supprimer ses commentaires
    /**
     * @Route("/pwd/user/delete-comment/{id}", name="removeUserComment", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function removeUserComment(Comment $comment, EntityManagerInterface $em): RedirectResponse
    {


        $em->remove($comment);
        $em->flush();

        return $this->RedirectToRoute('home');
    }

    // function qui permet à l'admin de supprimer les articles
    /**
     * @Route("/pwd/admin/article-delete/{id}", name="removeArticle", methods={"GET"})
     */
    public function removeArticles(Article $article, EntityManagerInterface $em): RedirectResponse
    {
        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute("list-articles");
    }

    // // function qui permet à l'admin de supprimer les magasins
    /**
     * @Route("/pwd/admin/store-delete/{id}", name="removeStore", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function removeStore(Store $store, EntityManagerInterface $em): RedirectResponse
    {
        $em->remove($store);
        $em->flush();

        return $this->redirectToRoute("list-store");
    }

}