<?php

namespace Mercedes\VStoreBundle\Model\Vehicle;

class CClass extends Automobile {
    
    const className     = "C-Class";
    const classPrice    = 28000;
    const airCondType   = "clima";
    const airbagSlug    = "airbag";
    const airBagNumber  = 6;
    
    public function __construct() {
        parent::__construct(self::className, self::classPrice);
        $this->equipCar();
    }

    public function equipCar() {
        
        $cClassDefSpecs =  SpecStorage::getCommonSpecifications();
        array_push($cClassDefSpecs, SpecStorage::getSpecification(self::airCondType));
        array_push($cClassDefSpecs, SpecStorage::getSpecification(self::airbagSlug,  self::airBagNumber));
        array_push($cClassDefSpecs, SpecStorage::getSpecification("cruise"));
        $this->assignDefaultSpecs($cClassDefSpecs);
    }

}
