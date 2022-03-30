<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Form\ProjetType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjetController extends AbstractController
{
    /**
     * @Route("/projet", name="projet")
     */
    public function index(): Response
    {
        return $this->render('projet/index.html.twig', [
            'controller_name' => 'ProjetController',
        ]);
    }

    /**
     * @Route("/listp", name="Lprojet")
     */
    public function ListeEquipe(){
        $p=$this->getDoctrine()->getRepository(Projet::class)->findAll();
        return $this->render("projet/listeP.html.twig",array('tabP'=>$p));
    }

    /**
     * @Route("/addPro", name="addProjet")
     */
    public function addEquipe(Request $request){
        $p=new Projet();
        $form=$this->createForm(ProjetType::class,$p);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($p);
            $em->flush();
            return $this->redirectToRoute('Lprojet');
        }
        return $this->render("projet/addProjet.html.twig",array('formP'=>$form->createView()));
    }

    /**
     * @Route("/UppP/{id}", name="UppdetPro")
     */
    public function uppP(Request $request,$id){
        $p=$this->getDoctrine()->getRepository(Projet::class)->find($id);
        $form=$this->createForm(ProjetType::class,$p);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em=$this->getDoctrine()->getManager();

            $em->flush();
            return $this->redirectToRoute('Lprojet');
        }
        return $this->render("projet/UppProjet.html.twig",array('formP'=>$form->createView()));
    }


    /**
     * @Route("/SuppP/{id}", name="supProjet")
     */
    public function sup($id){
        $p=$this->getDoctrine()->getRepository(Projet::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($p);
        $em->flush();
        return $this->redirectToRoute('Lprojet');
    }
}
