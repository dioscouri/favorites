<?php
/**
 * @version 1.5
 * @package Favorites
 * @author  Dioscouri Design
 * @link    http://www.dioscouri.com
 * @copyright Copyright (C) 2007 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');
if ( !class_exists('Tags') ) {
    JLoader::register( "Favorites", JPATH_ADMINISTRATOR.DS."components".DS."com_favorites".DS."defines.php" );
}

class FavoritesHelperFavorites extends JObject
{
	
	public function addFavButton($object_id, $scope_id, $name, $url = null, $text = 'Add', $attribs = '') {
		$html = '';
		$html .= '<a id="fav'.$object_id.'-'.$scope_id.'" class="addFav favorites"';
		$html .= ' href="';
		$html .= $this->makeurl($object_id, $scope_id, $name, $url);
		$html .= '">'.$text;
		$html .= '</a>';
		
		
	}
	
	public function removeFavButton($fav_id, $object_id = NULL, $scope_id = NULL, $name = NULL ) {
		
	}
	
	public function favButton($fav_id, $object_id = NULL, $scope_id = NULL, $name = NULL ) {
		// this will be the function used to generate buttons in layouts. 
	
	// do itemCheck
	
	//than if item exits, show the remove button, if not show the add button. 
	}
	
	
	function makeurl($object_id, $scope_id, $name, $url = null) {
		
		//$u = JFactory::getURI();
		$url = '';
		$url .= JURI::root();
		$url .= '/index.php?option=com_favorites&task=add&format=raw&view=items';
		if(!empty($object_id)){
		$url .= '&oid='.$object_id;	
		}
		if(!empty($scope_id)){
		$url .= '&sid='.$scope_id;	
		}
		if(!empty($name)){
		$url .= '&n='.$name;	
		}
		if(!empty($url)){
		$url .= '&u='.$url;	
		}
		
		return $url;
	}
}