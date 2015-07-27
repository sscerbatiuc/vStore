<?php

namespace Mercedes\VStoreBundle\Model;

use Mercedes\VStoreBundle\Model\Vehicle\Automobile;
use Mercedes\VStoreBundle\Model\Helper\Helper;

class AutomobileFactory {

    private $vehicleStore;

    /**
     * (Singleton Pattern)
     * Returns only one instance of the class
     * @staticvar type $instance
     * @return \static
     */
    public static function getInstance() {
        static $instance = null;
        if ($instance == null) {
            $instance = new static();
        }
        return $instance;
    }

    public function __construct() {
        
    }

    //Prevent cloning the instance of the object AutomobileFactory - Singleton pattern    
    private function __clone() {
        
    }

    private function __wakeup() {
        
    }

    /** Creates a vehicle of specific Class based on the user input: A,B,C,E,S
     * @param String $className
     * @return Automobile
     */
    public function createVehicle($inputVehicleClass) {
        $vehicleClass = ucfirst($inputVehicleClass);
//        return new Vehicle\AClass();
        $vehicle = $vehicleClass . "Class";
        switch ($vehicle) {
            case "AClass": {
                    return new Vehicle\AClass();
                }
            case "BClass": {
                    return new Vehicle\BClass();
                }
            case "CClass": {
                    return new Vehicle\CClass();
                }
            case "EClass": {
                    return new Vehicle\EClass();
                }
            case "SClass": {
                    return new Vehicle\SClass();
                }
            default : {
                    Helper::displayErrorMessage("The vehicle (" . $vehicle . ") couldn't be created.");
                    return NULL;
                }
        }
//        if (class_exists("Mercedes/VStoreBundle/Model/" . $vehicle)) {
//            $newVehicle = new $vehicle();
//            return $newVehicle;
//        } else {
//
//            Helper::displayErrorMessage("The vehicle (" . $vehicle . ") couldn't be created.");
//            return NULL;
//        }
    }

}
