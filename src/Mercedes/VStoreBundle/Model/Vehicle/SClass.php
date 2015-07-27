<?php

namespace Mercedes\VStoreBundle\Model\Vehicle;

use Mercedes\VStoreBundle\Model\Specification\SpecStorage;


class SClass extends Automobile {

    const className     = "S-Class";
    const classPrice    = 55000;
    const airCondType   = "climaZona";
    const airbagSlug    = "airbag";
    const airBagNumber  = 10;


    public function __construct() {
        parent::__construct(self::className, self::classPrice);
        $this->equipCar();
    }
    
    public function equipCar() {
        $sClassDefSpecs = SpecStorage::getCommonSpecifications();

        array_push($sClassDefSpecs, SpecStorage::getSpecification(self::airCondType));
        array_push($sClassDefSpecs, SpecStorage::getSpecification(self::airbagSlug, self::airBagNumber));
        array_push($sClassDefSpecs, SpecStorage::getSpecification("xenon"));
        array_push($sClassDefSpecs, SpecStorage::getSpecification("scauneRegl"));
        array_push($sClassDefSpecs, SpecStorage::getSpecification("senzor-lumina"));
        array_push($sClassDefSpecs, SpecStorage::getSpecification("senzor-ploaie"));
        array_push($sClassDefSpecs, SpecStorage::getSpecification("piele"));
        array_push($sClassDefSpecs, SpecStorage::getSpecification("parktronic"));
        array_push($sClassDefSpecs, SpecStorage::getSpecification("calculator"));
        array_push($sClassDefSpecs, SpecStorage::getSpecification("cruise"));

        $this->assignDefaultSpecs($sClassDefSpecs);
    }

}
