<?php

namespace Mercedes\VStoreBundle\Model\Helper;

class Time {
    
    /**
     * Returns the current date in the format ("DD.MM.YYYY")
     * @return date
     */
    public static function getCurrentDate(){
        return strtotime(date("d.m.Y"));
    }
    
    /**
     * Returns the first day of the current year (January 1st)
     * @return date
     */
    public static function getFirstDayOfYear() {
        
        $currentYear = date("Y");
        $firstDay = date("d.m.Y", strtotime("01.01.".$currentYear));
        return $firstDay;
    }
    
    /**
     * Returns the last day of the year (December 31st)
     * @return date
     */
    public static function getLastDayOfYear() {
        
        $currentYear = date("Y");
        $lastDay = date("d.m.Y", strtotime("31.12.".$currentYear));
        return $lastDay;
    }
    
    /**
     * Checks if the current day is between a given interval
     * @param string $startDate
     * @param string $endDate
     * @return boolean TRUE - is between; FALSE - otherwise
     */
    public static function checkIfBetween($start, $end) {

        $today = self::getCurrentDate();
        $startDate = strtotime($start);
        $endDate = strtotime($end);
        $result = ($today < $endDate) && ($today > $startDate);
//        print_r($result ? "Is between" : "Is outside the interval");
        return $result;
    }

}
