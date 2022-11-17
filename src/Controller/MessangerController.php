<?php

namespace App\Controller;

use App\Entity\Messanger;
use App\Form\MessangerType;
use App\Form\RecherchemType;
use App\Repository\MessangerRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessangerController extends AbstractController
{
    #[Route('/messanger', name: 'app_messanger')]
    public function index(): Response
    {
        return $this->render('messanger/index.html.twig', [
            'controller_name' => 'MessangerController',
        ]);
    }
    #[Route('/readm', name: 'read_messanger')]
    public function readmessanger(ManagerRegistry $doctrine):Response
    {$liste= $doctrine->getRepository(Messanger::class)
        ->findAll();
        return $this->render('messanger/readm.html.twig',['list1'=>$liste]) ;
    }
    #[Route('/addm', name: 'add_messanger')]
    public function addmsg(ManagerRegistry $doctrine,Request $Request):Response
    {//$entitymanager = $doctrine->getManager();
        $obj= new Messanger();
        $form = $this->createForm(MessangerType::class,$obj);
        $form->handleRequest($Request);
        if(($form->isSubmitted())&&($form->isValid()))
        {
            $em=$doctrine->getManager();
            $em->persist($obj);
            $em->flush();
            return $this->redirectToRoute('read_messanger');
        }
        else{
            return $this->render('messanger/addm.html.twig',['f'=>$form->createView()]);

        }
    }
    #[Route('/supp/{id}', name: 'supp_messanger')]
    public function supprimer($id,ManagerRegistry $doctrine):Response
    {$obj=$doctrine->getRepository(Messanger::class)->find($id);
        $em=$doctrine->getManager();
        $em->remove($obj);
        $em->flush();
        return $this->redirectToRoute('read_messanger');


    }


    }

