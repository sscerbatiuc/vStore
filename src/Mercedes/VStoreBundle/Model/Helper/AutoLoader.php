<?php

namespace Mercedes\VStoreBundle\Model\Helper;

class AutoLoader {
    
    /**
     * Loads all the classes of the project
     */
    public static function ClassLoader() {

        require_once 'Helper/Time.php';
        require_once 'Helper/Helper.php';

        require_once 'Model/AutomobileFactory.php';
        require_once 'Model/Vehicle/Automobile.php';
        require_once 'Model/Vehicle/AClass.php';
        require_once 'Model/Vehicle/BClass.php';
        require_once 'Model/Vehicle/CClass.php';
        require_once 'Model/Vehicle/EClass.php';
        require_once 'Model/Vehicle/SClass.php';

        require_once 'Model/Discount/Reduceri.php';
        require_once 'Model/Discount/VipDiscount.php';
        require_once 'Model/Discount/OrdinaryDiscount.php';
        require_once 'Model/Discount/OrderInterface.php';

        require_once 'Model/Specifications/Spec.php';
        require_once 'Model/Specifications/SpecStorage.php';

        require_once 'Model/VehicleStore.php';
    }

}
