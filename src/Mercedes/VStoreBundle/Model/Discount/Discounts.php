<?php

namespace Mercedes\VStoreBundle\Model\Discount;

use Mercedes\VStoreBundle\Model\Discount\OrderingInterface;

abstract class Discounts implements OrderingInterface {
    
    const fixedDiscount = 1;
    const percentDiscount= 0;
    
    private $order;
    
    private $description;
    
    /**
     * Sets whether the option is active or not
     * @var boolean 
     */
    private $isActive;
    
    /**
     * Defines the discount value of the option
     * @var int 
     */
    private $discountValue;
    
    /**
     *Defines the type of the discount: Fixed or Percent
     * @var int 0 - Percent; 1 - Fixed
     */
    private $discountType;
    
    /**
     * Defines when the discount option is active
     */
    abstract public function isActive();
    
    /**
     * Displays all the information about the discount option
     */
    abstract public function __toString();

    //GETTERS
    
    function getDiscountValue() {
        return $this->discountValue;
    }
    
    /**
     * Returns a short description of each discount option
     * @return string
     */
    function getDescription() {
        return $this->description;
    }
    
    /**
     * Checks whether the option is active or not
     * @return boolean TRUE, when active, FALSE - otherwise
     */
    function getIsActive() {
        return $this->isActive;
    }
    
    /**
     * Returns the order of application of the discount option
     * @return int Lower order - higher priority
     */
    public function getOrder() {
        return $this->order;
    }
    
    /**
     * Returns the type of the discount option: Fixed - discount value is substracted
     * directly; Percent - the discount value is calculated (%)
     * @return int 1 - Fixed, 0 - Percent
     */
    function getDiscountType() {
        return $this->discountType;
    }

    
    //SETTERS
    function setDiscountValue($discountValue) {
        $this->discountValue = $discountValue;
    }

    function setIsActive($isActive) {
        $this->isActive = $isActive;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setOrder($order) {
        $this->order = $order;
    }
    
    function setDiscountType($discountType) {
        $this->discountType = $discountType;
    }
}
