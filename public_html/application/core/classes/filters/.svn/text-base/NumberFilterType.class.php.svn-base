<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/FilterType.class.php';

/**
 * Numeric filter types definition (equals, lower than, greater than, etc)
 * @author gabriel.guzman
 *
 */
class NumberFilterType extends FilterType{
    
    function __construct(){
        
        $values = array(
                        searchFilters::EQUALS=>'equalssymbol',
                        searchFilters::LOWERTHAN=>'lowerthansymbol',
                        searchFilters::LOWEREQUALSTHAN=>'lowerequalsthansymbol',
                        searchFilters::GREATERTHAN=>'greaterthansymbol',
                        searchFilters::GREATEREQUALSTHAN=>'greaterequalsthansymbol',
                        searchFilters::DISTINCT=>'distinctsymbol',
                        searchFilters::CONTAINSINFO=>searchFilters::CONTAINSINFO,
                        searchFilters::NOTCONTAINSINFO=>searchFilters::NOTCONTAINSINFO
                        );
        
        parent::setValues($values);
        
    }
    
}