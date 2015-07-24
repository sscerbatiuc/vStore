<?php

namespace Mercedes\VStoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Constraints as Assert;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('MercedesVStoreBundle:Default:index.html.twig');
    }
    /**
     * @Route("/cars",name="selectClass")
     * @return type
     */
    public function carAction(){
        return $this->render('MercedesVStoreBundle:Default:vehicles.html.twig');
    }
    
    /**
     * @Route("/car/{className}", name="viewCar")
     * @return type
     */
    public function viewCarAction($className){
        
        return $this->render('MercedesVStoreBundle:Default:car.html.twig', array("className" => $className));
    }
    
    /**
     * @Route("/spec", name="viewSpecifications")
     * @return type
     */
    public function specAction(){
        return $this->render('MercedesVStoreBundle:Default:spec.html.twig');
    }
    
    /**
     * @Route("/discount",name="viewDiscountOptions")
     * @return type
     */
    public function discountAction(){
        return $this->render('MercedesVStoreBundle:Default:discount.html.twig');
    }
}
