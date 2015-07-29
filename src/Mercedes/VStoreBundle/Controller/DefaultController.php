<?php

namespace Mercedes\VStoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Mercedes\VStoreBundle\Model\Helper\Helper;
use Mercedes\VStoreBundle\Model\Specification\SpecStorage;
use Mercedes\VStoreBundle\Model\DatabaseUtils\DbUtils;
use Mercedes\VStoreBundle\Entity\Specification;

class DefaultController extends Controller {
    
    /**
     * Homepage
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
        $session = $request->getSession();
        return $this->render('MercedesVStoreBundle:Default:index.html.twig', array("activeMenuItem" => "home"));
    }

    /**
     * When user clicks on the car button on the menu, he is redirected to this page
     * @Route("/cars",name="selectClass")
     * @return type
     */
    public function carAction() {
        return $this->render('MercedesVStoreBundle:Default:vehicles.html.twig', array("activeMenuItem" => "cars"));
    }

    /**
     * On the page with classes, the user can select a specific class
     * @Route("/car/{className}", name="viewCar")
     * @return type
     */
    public function viewCarAction($className, Request $request) {
        $session = $request->getSession();
        $vehicle = $this->get('AutoFactory');
        $vehicle::getInstance();
        $car = $vehicle->createVehicle($className);
        $session->set("automobile", $car);
        
        $entityManager = $this->getDoctrine();
        $repository = $entityManager->getRepository('MercedesVStoreBundle:Specification');
        $specs = $repository->findAll();
        
        $availableSpecs = SpecStorage::adjustOptionalSpecifications($car->getDefaultSpecs(), $specs);
        return $this->render('MercedesVStoreBundle:Default:car.html.twig', array("specifications" => $availableSpecs, "activeMenuItem" => "cars"));
    }

    /**
     * Displays the general information about the specifications that can be added to the vehicles
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
     * Generates an json using the information about the specifications from the DB 
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
     * Displays the general information about the discount options available
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
    
    /**
     * Equips the vehicle objects with the selected specification from the modal window
     * @Route("/addSpec/{specSlug}", name="addSpecification")
     * @param string $specSlug
     * @return Response
     */
    public function addSpecificationAction(Request $request, $specSlug){
        $session = $request->getSession();
        $automobile = $session->get("automobile");
        $automobile->equipOptionalSpec($specSlug);
        dump($automobile);
        dump($automobile->getOptionalSpecs());
//        $session->clear();
        $session->set("automobile", $automobile);
        return new Response();
    }

}
