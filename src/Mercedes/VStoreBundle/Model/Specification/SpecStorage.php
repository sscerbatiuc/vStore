<?php

namespace Mercedes\VStoreBundle\Model\Specification;

class SpecStorage{
    
    /**
     * Default specifications for all the cars
     */
    const mp3Name           = "MP3 Player";
    const elecMirrorName    = "Electric mirrors";
    const lockName          = "Central lock";
    const elecWindowName    = "Electric Windows";
    const fogLightsName     = "Fog Lights";
    const heatMirrorName    = "Heated Mirrors";
    
    /**
     * Optional Specifications
     */
    const xenonName         = "Xenon";
    const steerWheelName    = "Multifunctional Steering Wheel";
    const parkName          = "Parktronic";
    const lightSensName     = "Light Sensor";
    const rainSensName      = "Rain Sensor";
    const theftAlarmName    = "Anti Theft Alarm";
    const rimsName          = "Lightweight Rims";
    const heatedSeatsName   = "Heated Seats";
    const cruControlName    = "Cruise Control";
    const boardComputerName = "Board Computer";
    
    const airCondName       = "Air conditioning";
    const climateName       = "Climate Control";
    const zonalClimateName  = "Climate Control with 2 zones";
    const airbagName        = "Airbags";
    const leatherSeatsName  = "Leather Seats";
    const electricAdjustName = "Seats with electrical adjustment";
    
    
    /**
     * Optional Specifications Price
     */
    const xenonPrice            = 500;
    const stWheelPrice          = 600;
    const parkPrice             = 250;
    const lightSensPrice        = 150;
    const rainSensPrice         = 300;
    const theftAlarmPrice       = 300;
    const rimsPrice             = 1000;
    const heatSeatsPrice        = 500;
    const cruControlPrice       = 1000;
    const boardComputerPrice    = 1500;
    
    private static $commonSpecifications = array(
        "mp3"       => array("Name" => self::mp3Name , "Price" => 0, "Quantity" => 1),
        "eMirror"   => array("Name" => self::elecMirrorName , "Price" => 0, "Quantity" => 2),
        "lock"      => array("Name" => self::lockName , "Price" => 0, "Quantity" => 1),
        "eWindow"   => array("Name" => self::elecWindowName, "Price" => 0, "Quantity" => 4),
        "fog"       => array("Name" => self::fogLightsName, "Price" => 0, "Quantity" => 2),
        "hMirror"   => array("Name" => self::heatMirrorName, "Price" => 0, "Quantity" => 2)        
    );
    
    private static $optionalSpecifications = array(
        "cond"          => array("Name" => self::airCondName, "Price" => 0, "Quantity" => 1),
        "clima"         => array("Name" => self::climateName, "Price" => 0, "Quantity" => 1),
        "climaZona"     => array("Name" => self::zonalClimateName, "Price" => 0, "Quantity" => 1),
        "airbag"        => array("Name" => self::airbagName, "Price" => 0, "Quantity" => 6),
        "piele"         => array("Name" => self::leatherSeatsName, "Price" => 0, "Quantity" => 1),
        "scauneRegl"    => array("Name" => self::electricAdjustName, "Price" => 0, "Quantity" => 2),
        "xenon"         => array("Name" => self::xenonName, "Price"=> self::xenonPrice, "Quantity" => 1),
        "volan"         => array("Name" => self::steerWheelName, "Price" => self::stWheelPrice, "Quantity" => 1),
        "parktronic"    => array("Name" => self::parkName, "Price" => self::parkPrice, "Quantity" => 1),
        "senzor-lumina" => array("Name" => self::lightSensName, "Price" => self::lightSensPrice, "Quantity" => 1),
        "senzor-ploaie" => array("Name" => self::rainSensName, "Price" => self::rainSensPrice, "Quantity" => 1),
        "alarma"        => array("Name" => self::theftAlarmName, "Price" => self::theftAlarmPrice, "Quantity" => 1),
        "jante"         => array("Name" => self::rimsName, "Price" => self::rimsPrice, "Quantity" => 4),
        "scauneIncalz"  => array("Name" => self::heatedSeatsName, "Price" => self::heatSeatsPrice, "Quantity" => 4),
        "cruise"        => array("Name" => self::cruControlName, "Price" => self::cruControlPrice, "Quantity" => 1),
        "calculator"    => array("Name" => self::boardComputerName, "Price" => self::boardComputerPrice, "Quantity" => 1)
    );
    
    /**
     * Returns the array with the available specifications
     * @return array
     */
    public static function getAvailableOptionalSpecifications(){
        $availableSpecs = array();
        foreach (self::$optionalSpecifications as $name => $specification) {
            if($specification["Price"] > 0){
                array_push($availableSpecs, $specification);
            }
        }
        return $availableSpecs;
    }

        /**
     * Returns an array with the specifications common for all the cars
     * @return array
     */
    public static function getCommonSpecifications(){
        $defSpecs = array();
        
        foreach (self::$commonSpecifications as $spec => $specDetails) {
            array_push($defSpecs, new Spec($specDetails["Name"],$specDetails["Price"],$specDetails["Quantity"]));
        }
        
        return $defSpecs;
    }
    
    /**
     * Returns a Spec (specification) object depending on user input
     * @param Specification Name
     * @return Spec
     */
    public static function getSpecification($nameSpec, $default = NULL){
        
        if(isset(self::$optionalSpecifications)){
            return new Spec(self::$optionalSpecifications[$nameSpec]["Name"],
                            self::$optionalSpecifications[$nameSpec]["Price"],
                            (isset($default) ? $default : self::$optionalSpecifications[$nameSpec]["Quantity"]));
        }
        else{
            Helper::displayErrorMessage("The specification (".$nameSpec.") doesn't exist");
            return NULL;
        }
        
    }
    
    /**
     * Checks whether a specification exists and can be created
     * @param type $nameSpec
     * @return type
     */
    public static function checkSpec($nameSpec){
        $result = array_key_exists($nameSpec,self::$optionalSpecifications);
        return $result;
    }
    
    /**
     * Filters the available specifications list for a specific vehicle, therefore preventing from adding optional specifications that exist in default specifications list
     * @param array $carDefault
     * @param array $availableSpecs
     * @return array
     */
    public static function adjustOptionalSpecifications($carDefault, $availableSpecs){
        
        $optionalSpecs = $availableSpecs;
        
        foreach ($optionalSpecs as $key => $specificationObject) {
            if(array_key_exists($specificationObject->getNameSpec(), $carDefault)){
                unset($optionalSpecs[$key]);
            }
        }
        return $optionalSpecs;
    }
}