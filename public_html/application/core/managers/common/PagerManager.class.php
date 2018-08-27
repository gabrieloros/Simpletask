<?php
/**
 * pagerManager.class.php
 *
 * @package core.managers.common
 * @author Gabriel Guzman
 * DATE OF CREATION: 20/03/2012
 * PURPOSE: paging management
 * 
 */
class PagerManager {
	
	private static $instance;
	
	private static $logger;
	
	public static function getInstance() {
		if (! isset ( PagerManager::$instance )) {
			self::$instance = new PagerManager ();
		}
		return PagerManager::$instance;
	}
	
	private function __construct() {
		
		self::$logger = $_SESSION ['logger'];
	
	}
	
	/**
	 * pages     - Array of all pages. Each array item must contain the keys "url" and "text".
	 * previous  - Url for the previous page (if it is not sent it will not show up)
	 * next      - Url for the next page (if it is not sent it will not show up)
	 * first     - Url for the first page (if it is not sent it will not show up)
	 * last      - Url for the last page (if it is not sent it will not show up)
	 * page      - Current page (must match pages.X.text)
	 */
	private function getPagerArray($pages, $page, $previous = '', $next = '') {
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' start' );
		
		$render = '';
		if (is_array ( $pages )) {
			$maxPages = 5;
			if (isset ( $_SESSION ['s_parameters'] ['pager_max_pages'] ) && (intval ( $_SESSION ['s_parameters'] ['pager_max_pages'] ) > 0)) {
				$maxPages = $_SESSION ['s_parameters'] ['pager_max_pages'];
			}
			
			$globalFirstPage = 0;
			$globalLastPage = count ( $pages );
			$firstPage = $page;
			$lastPage = $page;
			$count = 0;
			$control = true;
			while ( $count < ($maxPages) ) {
				if ((($control) && ($firstPage == $globalFirstPage)) || ((! $control) && ($lastPage != $globalLastPage))) {
					if (($lastPage + 1) <= $globalLastPage) {
						$lastPage ++;
					}
				} else {
					if (($firstPage - 1) >= $globalFirstPage) {
						$firstPage --;
					}
				}
				$control = ! $control;
				$count ++;
			}
			
			$pageList = array_slice ( $pages, $firstPage, $lastPage - $firstPage );
			$lastPageIndex = $globalLastPage - 1;
			
			$morePagesPrevious = false;
			if ($firstPage > 0) {
				$morePagesPrevious = true;
			}
			
			$morePagesNext = false;
			if ($lastPage < $globalLastPage) {
				$morePagesNext = true;
			}
			
			if ($page > 1) {
				$first = $pages [0] ['url'];
			} else {
				$first = '';
			}
			
			if ($page <= $lastPageIndex) {
				$last = $pages [$lastPageIndex] ['url'];
			} else {
				$last = '';
			}
		}
		
		$page_array ['page'] = $page;
		$page_array ['pageList'] = $pageList;
		$page_array ['previous'] = $previous;
		$page_array ['next'] = $next;
		$page_array ['first'] = $first;
		$page_array ['last'] = $last;
		$page_array ['morePagesPrevious'] = $morePagesPrevious;
		$page_array ['morePagesNext'] = $morePagesNext;
		$page_array ['url'] = '/' . $_SESSION ['s_languageIsoUrl'] . '/' . $_REQUEST ['urlargs'] [1];
		if(isset($_REQUEST['action']) && $_REQUEST['action'] != null){
			$page_array ['url'] .= '?action=' . $_REQUEST['action'];
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $page_array;
	}
	
	/**
	 * 
	 * Returns array in order to construct the pager.
	 * @param Number of images for page $itemsForPage
	 * @param Number of total items $numberItems
	 * @param Actual Pager $page
	 */
	public function setPager($itemsForPage, $numberItems, $page) {
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' start' );
		
		if ($numberItems > 0) {
			$realpage = $page - 1;
			$max_page = ceil ( $numberItems / $itemsForPage ) - 1;
			$need_pager = $max_page > 0 ? true : false;
			$page_not_found = $realpage > $max_page ? true : false;
			$initialImage = $realpage * $itemsForPage;
			if ($need_pager && ! $page_not_found) {
				for($x = 0; $x <= $max_page; $x ++) {
					$pager_array [$x] ['url'] = $x + 1;
					$pager_array [$x] ['text'] = $x + 1;
				}
				$max_page ++;
				$next = $page < $max_page ? $page + 1 : '';
				if ($page != 0 || $page != 1) {
					$previous = $page - 1;
				} else {
					$previous = '';
				}
				$page_array = self::getPagerArray ( $pager_array, $page, $previous, $next );
			} elseif (! $need_pager && ! $page_not_found) {
				$page_array = false;
			} elseif ($page_not_found) {
				$page_array = 'page not found';
			}
		} else {
			$pager_array = false;
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $page_array;
	}

}