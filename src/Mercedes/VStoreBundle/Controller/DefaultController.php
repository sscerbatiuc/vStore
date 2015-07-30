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
    public function navigateCarSectionAction(Request $request) {
        $session = $request->getSession();
        $session->clear();
        return $this->render('MercedesVStoreBundle:Default:vehicles.html.twig', array("activeMenuItem" => "cars"));
    }

    /**
     * On the page with classes, the user can select a specific class
     * @Route("/car/{className}", name="viewCar")
     * @return type
     */
    public function selectCarAction($className, Request $request) {

        $session = $request->getSession();
        $automobileFactory = $this->get('AutoFactory');
        $automobileFactory::getInstance();
        $car = $session->get("automobileSession");
        //Check whether the automobile is already registered in the session
        if ($car == NULL) {
            $car = $automobileFactory->createVehicle($className);
            $christmasDiscount = $this->get('OrdinaryDiscount');
            $car->addDiscountOption($christmasDiscount);
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
    public function displaySpecsAction(Request $request) {
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
    public function selectSpecAction(Request $request) {
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
    public function displayDiscountAction(Request $request) {
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
     * @return JSON Specification Name
     */
    public function addSpecificationAction(Request $request, $specSlug) {

        $session = $request->getSession();
        $vehicleToCustomize = $session->get("automobileSession");
        $vehicleToCustomize->equipOptionalSpec($specSlug);

        $specification = SpecStorage::getSpecification($specSlug);
        $specName = $specification->getNameSpec();

        $session->set("automobileSession", $vehicleToCustomize);

        $array = json_encode(array("specName" => $specName));
        $response = new Response($array);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Removes the optional specification from the vehicle held in the session
     * @Route("/removeSpec/{specSlug}", name="removeSpecification")
     * @param Request $request
     * @param string $specSlug
     * @return JSON Specification Name
     */
    public function removeSpecificationAction(Request $request, $specSlug) {

        $session = $request->getSession();
        $specificationToRemove = SpecStorage::getSpecification($specSlug);
        $removedSpecName = $specificationToRemove->getNameSpec();
        $vehicleToCustomize = $session->get("automobileSession");
        $vehicleToCustomize->deleteSpec($specSlug);
        $session->set("automobileSession", $vehicleToCustomize);
        $responseArray = json_encode(array("removedSpec" => $removedSpecName));
        $response = new Response($responseArray);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * Retrieves the recalculated price of the vehicle.
     * @Route("/price", name="priceCalculator")
     * @param Request $request
     * @return JSON Vehicle Price
     */
    public function displayRecalculatedPriceAction(Request $request) {
        $session = $request->getSession();
        $vehicle = $session->get("automobileSession");
        $newPrice = $vehicle->calculatePrice();

        $response = new Response(json_encode(array("newPrice" => $newPrice)));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * Assigns a specific discount option to the vehicle
     * @Route("/isVip/true")
     * @param string $discountType
     * @return Response
     */
    public function addVipDiscountAction(Request $request){
        
        $session = $request->getSession();
        $vipDiscount = $this->get('VipDiscount');
        $vehicle = $session->get('automobileSession');
        $vehicle->addDiscountOption($vipDiscount);
        $session->set("automobileSession", $vehicle);
        $response = new Response();
//        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    
    /**
     * Removes the Vip discount option from the vehicle stored in the session
     * @Route("/isVip/false")
     * @param Request $request
     * @return Response
     */
    public function removeVipDiscountAction(Request $request){
        $session = $request->getSession();
        $vipDiscount = $this->get('VipDiscount');
        $vehicle = $session->get('automobileSession');
        $vehicle->removeDiscountOption($vipDiscount);
        $session->set("automobileSession", $vehicle);
         $response = new Response();
//        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


    /**
     * Retrieves the information about the specifications from the DB
     * @return array
     */
    public function getSpecificationsDoctrine() {
        $entityManager = $this->getDoctrine();
        $repository = $entityManager->getRepository('MercedesVStoreBundle:Specification');
        $specs = $repository->findAll();
        return $specs;
    }

}
