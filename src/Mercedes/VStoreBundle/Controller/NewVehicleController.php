<?php

namespace Mercedes\VStoreBundle\Controller;

use Mercedes\VStoreBundle\Model\Automobile;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class NewVehicleController extends Controller{
    
   
    
    /**
     * @Route("/car", name="newCar")
     */
    public function newCarAction(Request $request){
         $car = new Automobile("A", "16000");
         
         $form=  $this->createFormBuilder($car)
                 ->add("vehicleMake","text")
                 ->add("vehicleClass", "text")
                 ->add("vehiclePrice","integer")
                 ->add("save","submit")
                 ->getForm();
         
         $form->handleRequest($request);
         if($form->isValid()){
             exit("Form was valid");
         } else {
             $this->redirect($this->generateUrl("homepage"));
         }
         
         return $this->render('MercedesVStoreBundle:Default:index.html.twig',array("newVehicleForm" => $form->createView()));
    }
}

