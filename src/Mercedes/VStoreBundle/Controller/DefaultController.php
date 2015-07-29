<?php

namespace Mercedes\VStoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Mercedes\VStoreBundle\Model\Specification\SpecStorage;

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
    public function carAction(Request $request) {
        $session = $request->getSession();
        $session->clear();
        return $this->render('MercedesVStoreBundle:Default:vehicles.html.twig', array("activeMenuItem" => "cars"));
    }

    /**
     * On the page with classes, the user can select a specific class
     * @Route("/car/{className}", name="viewCar")
     * @return type
     */
    public function viewCarAction($className, Request $request) {

        $session = $request->getSession();
        $automobileFactory = $this->get('AutoFactory');
        $automobileFactory::getInstance();
        $car = $session->get("automobileSession");
        //Check whether the automobile is already registered in the session
        if ($car == NULL) {
            $car = $automobileFactory->createVehicle($className);
            $session->set("automobileSession", $car);
        }
        $specs = $this->getSpecificationsDoctrine();

        $availableSpecs = SpecStorage::adjustOptionalSpecifications($car->getDefaultSpecs(), $specs);
        return $this->render('MercedesVStoreBundle:Default:car.html.twig', array("specifications" => $availableSpecs, "activeMenuItem" => "cars"));
    }

    /**
     * Displays the general information about the specifications that can be added to the vehicles
     * @Route("/spec", name="viewSpecifications")
     * @return twig
     */
    public function specAction(Request $request) {
        $session = $request->getSession();
        $session->clear();
        $specs = $this->getSpecificationsDoctrine();
        return $this->render('MercedesVStoreBundle:Default:spec.html.twig', array("specification" => $specs, "activeMenuItem" => "spec"));
    }

    /**
     * Generates an json using the information about the specifications from the DB 
     * @Route("/specSelect", name="selectSpecifications")
     * @return array
     */
    public function specSelectAction(Request $request) {
        $session = $request->getSession();
        $session->clear();
        $specs = $this->getSpecificationsDoctrine();
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
    public function discountAction(Request $request) {
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
    public function addSpecificationAction(Request $request, $specSlug) {

        $session = $request->getSession();
        $vehiclCustomize = $session->get("automobileSession");
        $vehiclCustomize->equipOptionalSpec($specSlug);
        $testSpec = $vehiclCustomize->getOptionalSpecs();
        $session->set("automobileSession", $vehiclCustomize);
        return new Response();
    }
    
    /**
     * Retrieves the information about the specifications from the DB
     * @return array
     */
    public function getSpecificationsDoctrine(){
        $entityManager = $this->getDoctrine();
        $repository = $entityManager->getRepository('MercedesVStoreBundle:Specification');
        $specs = $repository->findAll();
        return $specs;
    }
    
    /**
     * @Route("/price", name="priceCalculator")
     * @param Request $request
     */
    public function displayRecalculatedPriceAction(Request $request){
        $session = $request->getSession();
        $vehicle = $session->get("automobileSession");
        $newPrice = $vehicle->calculatePrice();
        $json = json_encode(array("newPrice" => $newPrice));
//        $response = new Response(json_encode(array("newPrice" => $newPrice)));
//        $response->headers->set('Content-Type', 'application/json');
        return new Response(json_encode(array("newPrice" => $newPrice)));
        
    }

}
