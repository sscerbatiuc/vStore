<?php

namespace Mercedes\VStoreBundle\Model\Discount;

class OrdinaryDiscount extends Reduceri {

    private $startDate;
    private $endDate;

    public function __construct($beginPeriodDate, $endPeriodDate, $discountValue, $description) {

        $this->setStartDate($beginPeriodDate);
        $this->setEndDate($endPeriodDate);
        $this->setDescription($description);
        $this->setDiscountType(parent::percentDiscount);
        $this->setOrder(1);
        $this->setDiscountValue($discountValue);
        $this->isActive();
    }
    
    //GETTERS
    
    function getStartDate() {
        return $this->startDate;
    }

    function getEndDate() {
        return $this->endDate;
    }
    
    //SETTERS
    
    public function setStartDate($start) {
        $this->startDate = $start;
    }

    public function setEndDate($end) {
        $this->endDate = $end;
    }
    
    /**
     * Defines what information shall be shown when discount objects are printed
     * @return string
     */
    public function __toString() {
        $info = "<strong>DISCOUNT INFORMATION</strong><br>"; 
        $info .= "<strong>Description:</strong> " . $this->getDescription();
        $info .= " <strong>Period:</strong> " . $this->getStartDate() . "-" . $this->getEndDate();
        $info .= " <strong>Discount Value:</strong>".  $this->getDiscountValue();
        $info .= (($this->getDiscountType() == 1) ? "&#8364" : "%");
        $info .= " <strong>Order of application:</strong> " . $this->getOrder();
        $info .= " <strong>Is Active? :</strong> " . ($this->getIsActive() ? "Yes" : "No");
        return $info."<br>";
    }

    /**
     * Checks whether a specific promotion is active at the moment
     * @return boolean
     */
    public function isActive() {
        $result = Time::checkIfBetween($this->startDate, $this->endDate);
        $this->setIsActive($result);
    }

    

}
