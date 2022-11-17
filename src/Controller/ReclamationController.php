<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\recherchetype;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class ReclamationController extends AbstractController
{
    #[Route('/reclamation', name: 'app_reclamation')]
    public function index(): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'controller_name' => 'ReclamationController',
        ]);
    }
    #[Route('/read', name: 'read_reclamation')]
    public function readreclamation(ManagerRegistry $doctrine):Response
    {$liste= $doctrine->getRepository(Reclamation::class)
        ->findAll();
        return $this->render('reclamation/read.html.twig',['list1'=>$liste]) ;
    }
    #[Route('/add', name: 'add_reclamation')]
    public function addreclamation(ManagerRegistry $doctrine,Request $Request):Response
    {//$entitymanager = $doctrine->getManager();
        $obj= new Reclamation();
        $form = $this->createForm(ReclamationType::class,$obj);
        $form->handleRequest($Request);
        if(($form->isSubmitted())&&($form->isValid()))
        {
            $em=$doctrine->getManager();
            $em->persist($obj);
            $em->flush();
            return $this->redirectToRoute('read_reclamation');
        }
        else{
            return $this->render('reclamation/add.html.twig',['f'=>$form->createView()]);

        }
    }
    #[Route('/supp/{idrec}', name: 'supp_reclamation')]
    public function supprimer($idrec,ManagerRegistry $doctrine):Response
    {$obj=$doctrine->getRepository(Reclamation::class)->find($idrec);
        $em=$doctrine->getManager();
        $em->remove($obj);
        $em->flush();
        return $this->redirectToRoute('read_reclamation');


    }
    #[Route('/updatee/{idrec}',name:'updatee')]
    public function update($idrec ,\Doctrine\Persistence\ManagerRegistry $doctrine,Request $REQUEST): Response
    { $obj=$doctrine
        ->getRepository(Reclamation::class)
        ->find($idrec);
        $form =$this->createForm(ReclamationType::class,$obj);
        $form ->add('modifier', SubmitType:: class);
        $form->handleRequest($REQUEST);
        if(($form->isSubmitted())&&( $form->isValid())){
            $em=$doctrine
                ->getManager();
            $em->flush(); //mise a jour de table w update
            return $this->redirectToRoute('read_reclamation');}
        else{
            return $this->renderForm('reclamation/update.html.twig',['f'=>$form]);

        }    }

   #[Route('/recherche',name:'rechercher')]
    public function rechercher(ReclamationRepository $reclamationRepository, Request $REQUEST){
        $listeR= $reclamationRepository->findAll();
        $form =$this->createForm(recherchetype::class);
        $form ->add('recherche', SubmitType:: class);
        $form->handleRequest($REQUEST);//traiter la requete
        if(($form->isSubmitted())){

            $Nom=$form['Nom']->getData();
            $listeR= $reclamationRepository->rechercheidrec($Nom);

            return $this->renderForm('reclamation/recherche.html.twig',['liste'=>$listeR,'f'=>$form]);}
        else{return $this->renderForm('reclamation/recherche.html.twig',['liste'=>$listeR,'f'=>$form]);

        }


    }
}
