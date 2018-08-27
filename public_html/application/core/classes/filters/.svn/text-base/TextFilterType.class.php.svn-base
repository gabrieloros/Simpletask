<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/FilterType.class.php';

/**
 * Text filter type definition (contains, begins with, etc.)
 * @author gabriel.guzman
 *
 */
class TextFilterType extends FilterType{
    
    function __construct(){
        
        $values = array(
                        searchFilters::CONTAINS=>searchFilters::CONTAINS,
                        searchFilters::BEGINSSWITH=>searchFilters::BEGINSSWITH,
                        searchFilters::ENDSWITH=>searchFilters::ENDSWITH,
                        searchFilters::EQUALS=>searchFilters::EQUALS,
                        searchFilters::CONTAINSINFO=>searchFilters::CONTAINSINFO,
                        searchFilters::NOTCONTAINSINFO=>searchFilters::NOTCONTAINSINFO
                        );
        
        parent::setValues($values);
        
    }
    
}