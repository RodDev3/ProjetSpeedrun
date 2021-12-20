<?php

namespace App\Controller;

use App\Entity\Plateform;
use App\Form\PlateformType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlateformController extends AbstractController
{
    //[Route('/plateform', name: 'plateform')]
    public function index(): Response
    {
        return $this->render('plateform/index.html.twig', [
            'controller_name' => 'PlateformController',
        ]);
    }
    
    /*Function permettant d'envoyer les donnees du formulaire Plateform vers la base de donnees*/
    function plateformForm(Request $request, ManagerRegistry $doctrine){
        
        //Creation of a new Object
        $plateform = new Plateform();

        //Creation of a form from PlateformType
        $form = $this->createForm(PlateformType::class, $plateform);
        $form->handleRequest($request);

        //Case of a submitted and valid form
        if($form->isSubmitted() && $form->isValid()){

            //Get data
            $plateform = $form->getData();
            $entityManager = $doctrine->getManager();

            //Send to db
            $entityManager->persist($plateform);
            $entityManager->flush();
        }

        //Rendering the form
        return $this->render('Plateform/index.html.twig',[
            'formulaire' => $form->createView()
        ]);
    }
}
