<?php

namespace Mercedes\VStoreBundle\Model;

use Symfony\Component\ClassLoader\Psr4ClassLoader;

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

    protected function __construct() {
        //Helper::displaySuccessMessage("Automobile Factory Constructor has been called successfully.");
        //Get the instance of the vehicleStore object where all the vehicles are stored 
//        $this->vehicleStore = VehicleStore::getInstance();
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
        $vehicle = $vehicleClass . "Class";
        if (class_exists($vehicle)) {
            $newVehicle = new $vehicle($inputVehicleClass);
            return $newVehicle;
        } else {

            Helper::displayErrorMessage("The vehicle (" . $vehicle . ") couldn't be created.");
            return NULL;
        }
    }

}
