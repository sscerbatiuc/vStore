<?php

namespace Mercedes\VStoreBundle\Model\Discount;

/**
 * VIP Discount is a discount option with fixed discount value
 * and is applied primarily to other discount options
 */
class VipDiscount extends Discounts {

    const description = "VIP Discount";
    const discountValue = 1000;
    const activeState = TRUE;
    const orderOfApplication = 0;

    public function __construct() {

        $this->setDescription(self::description);
        $this->setDiscountValue(self::discountValue);
        $this->setDiscountType(parent::fixedDiscount);
        $this->setOrder(self::orderOfApplication);
        $this->isActive();
    }

    /**
     * Defines what information shall be shown when discount objects are printed
     * @return string
     */ public function __toString() {
        $info = "<strong>DISCOUNT INFORMATION</strong><br>";
        $info .= "<strong>Description:</strong> " . $this->getDescription();
        $info .= " <strong>Discount Value:</strong> " . $this->getDiscountValue();
        $info .= (($this->getDiscountType() == 1) ? "&#8364" : "%");
        $info .= " <strong>Order of application:</strong> " . $this->getOrder();
        $info .= " <strong>Is Active?:</strong> " . ($this->getIsActive() ? "Yes" : "No");
        return "<p>".$info ."</p>";
    }

    /**
     * Defines the state of the VipDiscount object: Active || Non-active
     */
    public function isActive() {
        $this->setIsActive(self::activeState);
    }

}
