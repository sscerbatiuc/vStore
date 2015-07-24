<?php

namespace Mercedes\VStoreBundle\Model\Vehicle;

class BClass extends Automobile {

    const className     = "B-Class";
    const classPrice    = 25000;
    const airCondType   = "cond";
    const airbagSlug    = "airbag";
    const airBagNumber  = 6;

    public function __construct() {
        parent::__construct(self::className, self::classPrice);
        $this->equipCar();
    }

    public function equipCar() {
        
        $specs =  SpecStorage::getCommonSpecifications();
        array_push($specs, SpecStorage::getSpecification(self::airCondType));
        array_push($specs, SpecStorage::getSpecification(self::airbagSlug,  self::airBagNumber));
        $this->assignDefaultSpecs($specs);
    }

}
