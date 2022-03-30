<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Form\EquipeType;
use App\Form\SearchEquipeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EquipeController extends AbstractController
{
    /**
     * @Route("/equipe", name="equipe")
     */
    public function index(): Response
    {
        return $this->render('equipe/index.html.twig', [
            'controller_name' => 'EquipeController',
        ]);
    }

    /**
     * @Route("/listequipe", name="Lequipe")
     */
    public function ListeEquipe(){
        $equipe=$this->getDoctrine()->getRepository(Equipe::class)->findAll();
        return $this->render("equipe/liste.html.twig",array('tabEquipe'=>$equipe));
    }

    /**
     * @Route("/addEquipe", name="addequipeee")
     */
    public function addEquipe(Request $request){
        $equipe=new Equipe();
        $form=$this->createForm(EquipeType::class,$equipe);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($equipe);
            $em->flush();
            return $this->redirectToRoute('Lequipe');
        }
        return $this->render("equipe/addEquipe.html.twig",array('formEquipe'=>$form->createView()));
    }

    /**
     * @Route("/UppEquipe/{id}", name="Uppdetequipeee")
     */
    public function uppEquipe(Request $request,$id){
        $equipe=$this->getDoctrine()->getRepository(Equipe::class)->find($id);
        $form=$this->createForm(EquipeType::class,$equipe);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em=$this->getDoctrine()->getManager();

            $em->flush();
            return $this->redirectToRoute('Lequipe');
        }
        return $this->render("equipe/UppEquipe.html.twig",array('formEquipe'=>$form->createView()));
    }


    /**
     * @Route("/SuppEquipe/{id}", name="supEquipeee")
     */
    public function sup($id){
        $equipe=$this->getDoctrine()->getRepository(Equipe::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($equipe);
        $em->flush();
        return $this->redirectToRoute('Lequipe');
    }



    /**
     * @Route("/searchEquipe", name="searchEquipe")
     */
    public function searchEqupeByName(Request $request )
    {

            $nom = $request->get("search");

            $result = $this->getDoctrine()->getRepository(Equipe::class)->findBy(['nom'=>$nom]);
            return $this->render('equipe/search.html.twig', array('listSearch' => $result));

        }

    /**
     * @Route("/ordreASC", name="ordreA")
     */
    public function OrderByNameASD()
    {

        $result = $this->getDoctrine()->getRepository(Equipe::class)->OrderByNameA();
        return $this->render('equipe/Order.html.twig', array('ordreA' => $result));

    }

    /**
     * @Route("/ordreDESC", name="ordreD")
     */
    public function OrderByNameDESC()
    {

        $result = $this->getDoctrine()->getRepository(Equipe::class)->OrderByNameD();
        return $this->render('equipe/OrderDESC.html.twig', array('ordreD' => $result));

    }

    }
