<?php

class searchFilters {
	
	/**
	 * Control types
	 */
	const TEXT = 'text';
	const NUMBER = 'number';
	const DATE_RANGE = 'date_range';
	const SELECT_MULTIPLE = 'select_multiple';
	const SELECT = 'select';
	const TREE = 'tree';
	const SELECTION_LIST = 'selection_list';
	
	/**
	 * Filter combo types
	 */	
	//Text
	const CONTAINS = 'contains';
	const BEGINSSWITH = 'beginswith';
	const ENDSWITH = 'endswith';
	const EQUALS = 'equals';
	const CONTAINSINFO = 'containsinfo';
	const NOTCONTAINSINFO = 'notcontainsinfo';
	
	//Number
	const LOWERTHAN = 'lowerthan';
	const LOWEREQUALSTHAN = 'lowerequalsthan';
	const GREATERTHAN = 'greaterthan';
	const GREATEREQUALSTHAN = 'greaterequalsthan';
	const DISTINCT = 'distinct';

}


class Constants{
	
	const INSERTTRANSACTION = 'insert';
	const UPDATETRANSACTION = 'update';
	const DELETETRANSACTION = 'delete';
	
}