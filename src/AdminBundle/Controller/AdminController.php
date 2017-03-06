<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Blague;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
  /**
* @Route("/admin")
*/  
    public function indexAction(){
  return $this->render('AdminBundle:Default:index.html.twig',
                array ('blagues' => $this->readAction()));
    }
/**
 * @Route("/admin/create", name="createBlague")
 */
    public function createAction(Request $request){

       $blague = new Blague();
       $form = $this->createForm('AdminBundle\Form\BlagueType', $blague);
       $form->handleRequest($request);
       $em = $this->getDoctrine()->getManager();
       if ($form->isSubmitted() && $form->isValid()){
            $em->persist($blague);
            $em->flush($blague);
            return $this->forward('AdminBundle:Default:index.html.twig');
        }
            return $this->render('AdminBundle:Default:create.html.twig', 
                   array(
                       'form' => $form->createView(),
                   ));
    }
    /**
    * @Route("/admin/read")
    */ 
    public function readAction(){
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository("AdminBundle\Entity\Blague")->findAll(); 
    }
    /**
     * @Route("/admin/update/{id}", name="updateBlague")
     */
    public function updateAction(request $request){
        $em = $this->getDoctrine()->getManager();
        $id = $request->attributes->get('id');
        $blague = $em->getRepository("AdminBundle\Entity\Blague")->find($id);
        $updateForm = $this->createForm('AdminBundle\Form\BlagueType', $blague);
        $updateForm->handleRequest($request);
 
        
        if ($updateForm->isSubmitted() && $updateForm->isValid()) {
            $em->persist($blague);
            $em->flush($blague);
            return $this->forward('AdminBundle:Admin:Index');
        }
        return $this->render('AdminBundle:Default:update.html.twig', array(
            'blague' => $blague,
            'updateForm' => $updateForm->createView(),
        ));
    }

    /**
    * @Route("/admin/delete/{id}", name="deleteBlague")
    */
    public function deleteAction(request $request){
        $em = $this->getDoctrine()->getManager();
        $id = $request->attributes->get('id');
        $blague = $em->getRepository("AdminBundle\Entity\Blague")->find($id);
        if (!empty($blague)){
           $em->remove($blague);
           $em->flush();
        }
        return $this->forward('AdminBundle:Admin:Index');
    }
}