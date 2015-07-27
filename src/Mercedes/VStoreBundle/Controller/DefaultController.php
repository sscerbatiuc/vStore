<?php

namespace Mercedes\VStoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Mercedes\VStoreBundle\Model\Helper\Helper;
use Mercedes\VStoreBundle\Model\Specification\SpecStorage;

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
        $vehicle = $this->get('AutoFactory');
        $vehicle::getInstance();
        $car = $vehicle->createVehicle($className);
        return $this->render('MercedesVStoreBundle:Default:car.html.twig', array("vehicle" => $car));
    }
    
    /**
     * @Route("/spec", name="viewSpecifications")
     * @return type
     */
    public function specAction(){
        $specs = SpecStorage::getAvailableOptionalSpecifications();
        return $this->render('MercedesVStoreBundle:Default:spec.html.twig', array("specification" => $specs));
    }
    
    /**
     * @Route("/discount",name="viewDiscountOptions")
     * @return type
     */
    public function discountAction(){
        $vipDiscount = $this->get('VipDiscount');
        $christmasDiscount = $this->get('OrdinaryDiscount');
        $options = array();
        array_push($options, $christmasDiscount);
        array_push($options, $vipDiscount);
        return $this->render('MercedesVStoreBundle:Default:discount.html.twig', array("options" => $options));
    }
}


