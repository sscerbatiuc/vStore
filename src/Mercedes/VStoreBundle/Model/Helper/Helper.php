<?php

namespace Mercedes\VStoreBundle\Model\Helper;

class Helper{
    
    /**
     * Displays a simple message
     * @param string
     */
    public static function displayInfoMessage($message){
        
        echo '<p style="color:black">'.$message.'</p>';
    }
    
    /**
     * Displays an red colored message
     * @param String $message
     */
    public static function displayErrorMessage($message){
        
        echo '<p style="color:red">'.$message.'</p>';
    }
    
    /**
     * Displays green colored message
     * @param string
     */
    public static function displaySuccessMessage($message){
        
        echo '<p style="color:green">'.$message.'</p>';
    }
    
    /**
     * Displays a bold message
     * @param string
     */
    public static function displayBoldMessage($message){
        
        echo '<p style="font-weight:bold">'.$message.'</p>';
    }
    
    
    public static function generateClassName($userInput){
        
        return ucfirst($userInput)."-Class";
    }
}
