<?php
/* 
 * The Author: Stanislav Scerbatiuc.
 */

namespace Mercedes\VStoreBundle\Model\DatabaseUtils;
use Mercedes\VStoreBundle\Entity\Specification;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManager;


use Doctrine\DBAL\Connection;

class DbUtils {
    
    public static function getConnection(){
        
        return $connection;
    }
    
    public static function getSpecifications(){
        
    }
    
}