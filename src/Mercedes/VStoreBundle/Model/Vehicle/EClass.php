<?php

namespace Mercedes\VStoreBundle\Model\Vehicle;

use Mercedes\VStoreBundle\Model\Specification\SpecStorage;


class EClass extends Automobile {

    const className     = "E-Class";
    const classPrice    = 40000;
    const airCondType   = "clima";
    const airbagSlug    = "airbag";
    const airBagNumber  = 8;

    public function __construct() {
        
        parent::__construct(self::className, self::classPrice);
        $this->equipCar();
    }

    public function equipCar() {
         $eClassDefSpecs =  SpecStorage::getCommonSpecifications();
        array_push($eClassDefSpecs, SpecStorage::getSpecification(self::airCondType));
        array_push($eClassDefSpecs, SpecStorage::getSpecification(self::airbagSlug,  self::airBagNumber));
        array_push($eClassDefSpecs, SpecStorage::getSpecification("cruise"));
        array_push($eClassDefSpecs, SpecStorage::getSpecification("parktronic"));
        array_push($eClassDefSpecs, SpecStorage::getSpecification("senzor-ploaie"));
        $this->assignDefaultSpecs($eClassDefSpecs);
    }

}
