<?php

namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;



class ClientController extends Controller
{
  /**
* @Route("/")
*/  
     public function indexAction()
    {
        return $this->render('ClientBundle:Default:index.html.twig',  
        array('blagues' => $this->getBlague()));
    }
    public function getBlague(){
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository("AdminBundle\Entity\Blague")->findAll();    
    }
}
