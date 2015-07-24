<?php

namespace Mercedes\VStoreBundle\Model\Specification;

class Spec {

    private $nameSpec;
    private $price;
    private $quantity;

    //  CONSTRUCTORS
    public function __construct($name, $price = 0, $qty = 1) {
        $this->setNameSpec($name);
        if ($price > 0) {
            $this->setPrice($price);
        }
        if ($qty > 0) {
            $this->setQuantity($qty);
        }
    }

    //  GETTERS
    function getNameSpec() {
        return $this->nameSpec;
    }

    function getPrice() {
        return $this->price;
    }

    public function getQuantity() {

        return $this->quantity;
    }

    //  SETTERS
    public function setNameSpec($nameSpec) {
        $this->nameSpec = $nameSpec;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }
    
    public function __toString() {
        return "</br><strong>Specification: </strong> Name:".$this->getNameSpec()." Price:".$this->getPrice()." Quantity:".$this->getQuantity();
    }

}
