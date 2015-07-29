<?php

namespace Mercedes\VStoreBundle\Model\Vehicle;

use Mercedes\VStoreBundle\Model\Helper\Helper;
use Mercedes\VStoreBundle\Model\Specification\SpecStorage;

class Automobile {

    private $vehicleMake = "Mercedes-Benz";
    private $vehicleClass;
    private $vehiclePrice;
    private $defaultSpecs;
    private $optionalSpecs;
    private $discountOptions;

    public function __construct($class, $price) {
        $this->vehiclePrice = $price;
        $this->vehicleClass = $class;
        $this->discountOptions = array();
        $this->defaultSpecs = array();
        $this->optionalSpecs = array();
    }

    /**
     * 
     */
//    abstract function equipCar();

    //GETTERS
    function getVehicleMake() {
        return $this->vehicleMake;
    }

    function getVehicleClass() {
        return $this->vehicleClass;
    }

    function getVehiclePrice() {
        return $this->vehiclePrice;
    }
    
    function getDefaultSpecs() {
        return $this->defaultSpecs;
    }

    function getOptionalSpecs() {
        return $this->optionalSpecs;
    }

    
    // SETTERS
    public function setVehicleClass($vehicleClass) {
        $this->vehicleClass = $vehicleClass;
    }

    public function setVehiclePrice($vehiclePrice) {
        $this->vehiclePrice = $vehiclePrice;
    }
    
    /**
     * Displays the general information about the vehicle:
     * Make, Class, Price
     * @return string
     */
    public function __toString() {
        $generalInfo = '<br><strong> GENERAL INFORMATION: </strong><br>'
                . ' <strong>Make:</strong> ' . $this->vehicleMake
                . ' <strong>Class:</strong> ' . $this->vehicleClass
                . '  <strong>Initial price:</strong> ' . $this->vehiclePrice . '&#8364';
        return $generalInfo;
    }

     /**
     * Displays all the specifications of the Vehicle (Default & Optional)
     */
    public function viewAllSpecifications() {

        $this->viewDefaultSpecs();
        $this->viewOptionalSpecs();
    }

    /**
     * Displays the information about the default Specifications of the Vehicle
     */
    //TODO override __toString() in the Spec class
    public function viewDefaultSpecs() {
        $defaultSpecList = "<strong>Default specifications:</strong>";
        foreach ($this->defaultSpecs as $spec) {
            $defaultSpecList .= ('<br>' . $spec->getNameSpec());
            if ($spec->getQuantity() > 1) {
                $defaultSpecList .= (': ' . $spec->getQuantity());
            }
        }
        Helper::displayInfoMessage($defaultSpecList);
    }

    /**
     * Displays the optional specifications of the car
     */
    public function viewOptionalSpecs() {
        $optionalSpecList = "<strong>Optional Specifications:</strong>";
        if (empty($this->optionalSpecs)) {
            $optionalSpecList .= ('<br>' . "There are no optional specifications added for this vehicle");
        } else {
            foreach ($this->optionalSpecs as $optionalSpec) {
                $optionalSpecList .= ('<br>' . $optionalSpec->getNameSpec());
                $optionalSpecList .= (': ' . $optionalSpec->getPrice() . '&#8364');
            }
        }
        Helper::displayInfoMessage($optionalSpecList);
    }

    
      
    /**
     * Adds the default specification to the Vehicle
     * @param Spec $specification
     */
    public function addDefSpec(Spec $specification) {
        $specName = $specification->getNameSpec();
        $isSpecAdded = array_key_exists($specName, $this->defaultSpecs);
        if (!$isSpecAdded) {
            $this->defaultSpecs[$specName] = $specification;
        } else {
            Helper::displayErrorMessage("The specification is already added to the vehicle");
        }
    }

    /**
     * Assign the default specifications of a vehicle
     * @param array
     */
    public function assignDefaultSpecs($specsArray) {
        $errorInfo = array();
        foreach ($specsArray as $defSpec) {
            $specName = $defSpec->getNameSpec();
            if (!array_key_exists($specName, $this->defaultSpecs)) {
                $this->defaultSpecs[$specName] = $defSpec;
            } else {
                array_push($errorInfo, $specName);
            }
        }
        if (!empty($errorInfo)) {
            Helper::displayErrorMessage("These specifications are already assigned:");
            foreach ($errorInfo as $spec) {
                echo $spec . " ";
            }
        }
    }

    
    /**
     * Adds the optional specification to the Vehicle
     * @param Spec $optionalSpec
     */
    public function equipOptionalSpec($specificationName) {

        $specObject = SpecStorage::getSpecification($specificationName);
        if (isset($specObject)) {
            $isSpecAdded = array_key_exists($specificationName, $this->optionalSpecs);
            if (!$isSpecAdded) {
                $this->optionalSpecs[$specificationName] = $specObject;
            } else {
                
            }
        } else {
            
        }
    }

    /**
     * Adds multiple optional specifications to the Vehicle
     * @param Spec[] $optionalSpecsArray
     */
    public function equipMultipleOptionalSpecs($optionalSpecsArray) {
        foreach ($optionalSpecsArray as $optionalSpec) {
            $specName = $optionalSpec->getNameSpec();
            $isSpecAdded = array_key_exists($specName, $this->optionalSpecs);
            if (!$isSpecAdded) {
                $this->optionalSpecs[$specName] = $optionalSpec;
            } else {
                Helper::displayErrorMessage("The specification: " . $specName . " is already equipped");
            }
        }
    }
    

    /**
     * Checks if an optional specification is assigned to the vehicle -> deletes it
     * @param type $specification
     */
    public function deleteSpec($specName) {


        $specificationExists = SpecStorage::getSpecification($specName);
        if (!isset($specificationExists)) {
            Helper::displayErrorMessage("There is no such specification: " . $specName);
        } else {
            $isEquipped = isset($this->optionalSpecs[$specName]);
            if ($isEquipped) {
                Helper::displayInfoMessage("DELETING optional specification: " . $this->optionalSpecs[$specName]->getNameSpec());
                $deletedSpec = $this->optionalSpecs[$specName]->getNameSpec();
                unset($this->optionalSpecs[$specName]);
                Helper::displaySuccessMessage("The specification (" . $deletedSpec . ") was successfully deleted");
            } else {
                Helper::displayErrorMessage("This car is not equipped with: " . $specificationExists->getNameSpec());
            }
        }
    }
    
    
    /**
     * Adds discount options to the vehicle. 
     * Therefore, the price will be calculated with the discount value taken into account.
     * @param Reduceri $discountOption
     */
    public function addDiscountOption(Discounts $discountOption) {
        $optionClass = get_class($discountOption);
        $isOptionAdded = array_key_exists($optionClass, $this->discountOptions);
        if (!$isOptionAdded) {
            $this->discountOptions[$optionClass] = $discountOption;
            $this->rangeDiscountOptions();
        } else {
            Helper::displayErrorMessage("The discount option is already assigned to the vehicle");
        }
    }
    
     /**
     * Ranges the applicable discount options, depending on the order of each option
     */
    public function rangeDiscountOptions() {
        usort($this->discountOptions, array("Automobile", "compareDiscountOptions"));
    }
    

    /**
     * Displays all the available discount options applicable for the vehicle
     */
    public function viewDiscountOptions() {
        echo $this;
        Helper::displayInfoMessage("The discount options available for this vehicle");
        foreach ($this->discountOptions as $option) {
            echo $option;
        }
    }

    /**
     * Compares the discount options applicable for the vehicle by their orders
     * @param Reduceri $option1
     * @param Reduceri $option2
     * @return int &lt; 0 if <i>order1</i> is less than
     * <i>order2</i>; &gt; 0 if <i>order1</i>
     * is greater than <i>order2</i>, and 0 if they are
     * equal.
     */
    public function compareDiscountOptions(Discounts $option1, Discounts $option2) {

        return strcmp($option1->getOrder(), $option2->getOrder());
    }
    
   
    /**
     * Calculates the price of the vehicle with all the optional specifications 
     * included
     * @return string
     */
    public function calculatePrice() {
        $price = $this->getVehiclePrice();
        $recalculatedPrice = number_format($price, 2, ".", "");
        foreach ($this->optionalSpecs as $optionalSpec) {

            $recalculatedPrice += ($optionalSpec->getPrice());
        }

        foreach ($this->discountOptions as $discountOption) {
            if ($discountOption->getIsActive()) {
                $type = $discountOption->getDiscountType();
                $reductionValue = $discountOption->getDiscountValue();
                (($type == 1) ? $recalculatedPrice -= $reductionValue :
                                $recalculatedPrice -= ($recalculatedPrice * $reductionValue) );
            }
        }
        return $recalculatedPrice . "&#8364";
    }

}

