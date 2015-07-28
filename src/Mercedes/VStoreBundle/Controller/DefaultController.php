<?php

namespace Mercedes\VStoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Mercedes\VStoreBundle\Model\Helper\Helper;
use Mercedes\VStoreBundle\Model\Specification\SpecStorage;
use Mercedes\VStoreBundle\Model\DatabaseUtils\DbUtils;
use Mercedes\VStoreBundle\Entity\Specification;

class DefaultController extends Controller {
    
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
        $session = $request->getSession();
        return $this->render('MercedesVStoreBundle:Default:index.html.twig', array("activeMenuItem" => "home"));
    }

    /**
     * @Route("/cars",name="selectClass")
     * @return type
     */
    public function carAction() {
        return $this->render('MercedesVStoreBundle:Default:vehicles.html.twig', array("activeMenuItem" => "cars"));
    }

    /**
     * @Route("/car/{className}", name="viewCar")
     * @return type
     */
    public function viewCarAction($className, Request $request) {
        $session = $request->getSession();
        $vehicle = $this->get('AutoFactory');
        $vehicle::getInstance();
        $car = $vehicle->createVehicle($className);
        $entityManager = $this->getDoctrine();
        $repository = $entityManager->getRepository('MercedesVStoreBundle:Specification');
        $specs = $repository->findAll();
        return $this->render('MercedesVStoreBundle:Default:car.html.twig', array("vehicle" => $car, "specifications" => $specs, "activeMenuItem" => "cars"));
    }

    /**
     * @Route("/spec", name="viewSpecifications")
     * @return twig
     */
    public function specAction() {
//        $specs = SpecStorage::getAvailableOptionalSpecifications();
        $entityManager = $this->getDoctrine();
        $repository = $entityManager->getRepository('MercedesVStoreBundle:Specification');
        $specs = $repository->findAll();
        return $this->render('MercedesVStoreBundle:Default:spec.html.twig', array("specification" => $specs, "activeMenuItem" => "spec"));
    }

    /**
     * @Route("/specSelect", name="selectSpecifications")
     * @return array
     */
    public function specSelectAction() {
        $entityManager = $this->getDoctrine();
        $repository = $entityManager->getRepository('MercedesVStoreBundle:Specification');
        $specs = $repository->findAll();
        $jsonSpecs = array();
        foreach ($specs as $specification) {
            $jsonSpecs[$specification->getId()] = array($specification->getSlug() => $specification->getNameSpec());
        }
        $response = new Response(json_encode($jsonSpecs));
//        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/discount",name="viewDiscountOptions")
     * @return type
     */
    public function discountAction() {
        $vipDiscount = $this->get('VipDiscount');
        $christmasDiscount = $this->get('OrdinaryDiscount');
        $options = array();
        array_push($options, $christmasDiscount);
        array_push($options, $vipDiscount);
        return $this->render('MercedesVStoreBundle:Default:discount.html.twig', array("options" => $options, "activeMenuItem" => "discount"));
    }

}
