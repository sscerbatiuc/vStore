<?php

namespace Mercedes\VStoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Specification")
 */
class Specification {

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $namespec;

    /**
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $price;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $slug;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    private $id;

    /**
     * Set namespec
     *
     * @param string $namespec
     * @return Specification
     */
    public function setNamespec($namespec) {
        $this->namespec = $namespec;

        return $this;
    }

    /**
     * Get namespec
     *
     * @return string 
     */
    public function getNamespec() {
        return $this->namespec;
    }

    /**
     * Set price
     *
     * @param integer $price
     * @return Specification
     */
    public function setPrice($price) {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer 
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Specification
     */
    public function setSlug($slug) {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug() {
        return $this->slug;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    
}
