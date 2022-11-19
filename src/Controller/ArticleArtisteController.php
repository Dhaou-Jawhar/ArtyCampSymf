<?php

namespace App\Controller;

use App\Entity\ArticleArtiste;
use App\Repository\ArticleArtisteRepository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleArtisteController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: 'GET')]
    public function index(ArticleArtisteRepository $articleArtisteRepository): Response
    {
        $arts = $articleArtisteRepository->findBy([], ['createdAt' => 'DESC']);  //$arts va représenter le tab de tout les articles
        return $this->render('pages/home.html.twig', compact('arts')); //compact: pour passer notre variables à notre template
    }

    #[Route('/articles/{idArticle<[0-9]+>}', name: 'app_articles_show', methods: 'GET')]
    public function show(ArticleArtiste $article): Response
    {
        return $this->render('pages/show.html.twig', compact('article'));
    }

    #[Route('/articles/create', name: 'app_articles_create', methods: 'GET|POST')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createFormBuilder(new ArticleArtiste)
            ->add('nomA', TextType::class)
            ->add('descriptionA', TextareaType::class)
            // ->add('views',TextareaType::class)
            ->add('imageh', TextareaType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('pages/create.html.twig', ['form' => $form->createView()]);
    }


    #[Route('/articles/{idArticle<[0-9]+>}/modifier', name: 'app_articles_modif', methods: 'GET|POST')]
    public function modifier(Request $request, EntityManagerInterface $em, ArticleArtiste $article): Response
    {
        $form = $this->createFormBuilder($article)
            ->add('nomA', TextType::class)
            ->add('descriptionA', TextareaType::class)
            //->add('views',TextareaType::class)
            ->add('imageh', TextareaType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $em->flush();
            return $this->redirectToRoute('app_home');

        }

        return $this->render('pages/modifier.html.twig', [
            'article' => $article,
            'form' => $form->createView()]);
    }
}