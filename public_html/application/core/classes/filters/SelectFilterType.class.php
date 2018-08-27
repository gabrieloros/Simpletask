<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/FilterType.class.php';

/**
 * Select filter type definition
 * @author gabriel.guzman
 *
 */
class SelectFilterType extends FilterType{
    
    function __construct(){
        
        $values = array(
                        searchFilters::EQUALS=>'equalssymbol',
                        searchFilters::DISTINCT=>'distinctsymbol'
                        );
        
        parent::setValues($values);
        
    }
    
}