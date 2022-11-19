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
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Symfony\Component\Mime\Email;
use PHPMailer\PHPMailer\SMTP;
use Symfony\Component\Mailer\MailerInterface;

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
            $mail = new PHPMailer(true);

            $mail->isSMTP();// Set mailer to use SMTP
            $mail->CharSet = "utf-8";// set charset to utf8
            $mail->SMTPAuth = true;// Enable SMTP authentication
            $mail->SMTPSecure = 'tls';// Enable TLS encryption, `ssl` also accepted

            $mail->Host = 'smtp.gmail.com';// Specify main and backup SMTP servers
            $mail->Port = 587;// TCP port to connect to
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->isHTML(true);// Set email format to HTML

            $mail->Username = 'hazem.kharroubi@esprit.tn';// SMTP username
            $mail->Password = 'Messi@1925';// SMTP password

            $mail->setFrom('hazem.kharroubi@esprit.tn', 'Hazem Kharroubi');//Your application NAME and EMAIL
            $mail->Subject = 'Article bien créer';//Message subject
           // $mail->MsgHTML('bien créer');// Message body
            $mail->Body = '<h1>Article: ' . $request->request->get('nomA'). ' ajoutée avec succés </h1>';

            $mail->addAddress('hazem.kharroubi@esprit.tn', 'Hazem Kharroubi');// Target email


            $mail->send();

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