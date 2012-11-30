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
if (!class_exists('Favorites')) {
	JLoader::register("Favorites", JPATH_ADMINISTRATOR . "/components/com_favorites/defines.php");
}

JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_favorites/tables');

class FavoritesHelperFavorites extends JObject {

	function __construct(){
		DSC::loadJQuery();
		JHTML::_('script', 'favorites.js', 'media/com_favorites/js/');
	}

	public function addFavButton($object_id, $scope_id, $name, $url = null, $text = 'Add', $attribs = array() ) {
		if(empty($text)){
			$text = Favorites::getInstance()->get( 'favorites_add_text', 'Add' );
			
		}
		if(empty($attribs['addclass'])) {
			$attribs['addclass'] = Favorites::getInstance()->get( 'favorites_add_class', 'addFav favorites btn btn-primary' );
		}
		$html = '';
		$html .= '';
		$html .= '<a id="fav-' . $object_id . '-' . $scope_id . '" class="'.$attribs['addclass'].'"  data-loading-text="Loading..."';
		$html .= ' href="';
		$html .= $this -> makeurl($object_id, $scope_id, $name, $url);
		$html .= '">' . $text;
		$html .= '</a>';

		return $html;

	}

	public function removeFavButton($fid = null, $object_id = null, $scope_id = null, $name = null, $url = null, $text = 'remove', $attribs = array()) {
		if(empty($attribs['removeclass'])) {
			$attribs['removeclass'] = Favorites::getInstance()->get( 'favorites_remove_class', 'removeFav favorites btn btn-danger' );
		}
		if(empty($text)){
			$text = Favorites::getInstance()->get( 'favorites_remove_text', 'Remove' );
		}
		$html = ''; 
		$html .= '<a id="fav-' . $fid. '" class="'.$attribs['removeclass'].'"  data-loading-text="Loading..."';
		$html .= ' href="';
		$html .= $this -> removeurl($fid,$object_id, $scope_id, $name, $url);
		$html .= '">' . $text;
		$html .= '</a>';

		return $html;
	}

	public function favButton($object_id, $scope_id, $name, $url = null, $text = array(), $attribs = array()) {
		if(empty($text)){
			$text[0] = Favorites::getInstance()->get( 'favorites_add_text', 'Add' );
			$text[1] = Favorites::getInstance()->get( 'favorites_remove_text', 'Remove' );
		}
		if(empty($attribs)){
			$attribs['addclass'] = Favorites::getInstance()->get( 'favorites_add_class', 'addFav favorites btn btn-primary' );
			$attribs['removeclass'] = Favorites::getInstance()->get( 'favorites_remove_class', 'removeFav favorites btn btn-danger' );
		}
		$user = JFactory::getUser();
		if ($user -> id) {
			JModel::addIncludePath( JPATH_ADMINISTRATOR.'/components/com_favorites/models' );
			$model = DSCModel::getInstance('Items', 'FavoritesModel');
			
			$fid = $model -> checkItem($object_id, $scope_id, $name, $url, $user -> id);
		
			if ($fid) {
				return $this -> removeFavButton($fid, '','','','',$text[1]);
			} else {
				return $this -> addFavButton($object_id, $scope_id, $name, $url, $text[0] , $attribs);
			}
		}
	}

	function makeurl($object_id, $scope_id, $name, $url = null) {

		//$u = JFactory::getURI();
		$href = '';
		$href .= JURI::root();
		$href .= 'index.php?option=com_favorites&task=add&format=raw&view=items';
		if (!empty($object_id)) {
			$href .= '&oid=' . $object_id;
		}
		if (!empty($scope_id)) {
			$href .= '&sid=' . $scope_id;
		}
		if (!empty($name)) {
			$href .= '&n=' . $name;
		}
		if (!empty($url)) {
			$href .= '&u=' . $url;
		}
		//$href .= '&jsoncallback=test()';

		return $href;
	}
	function removeurl($fid = null,$object_id = null, $scope_id= null, $name= null, $url = null) {

		//$u = JFactory::getURI();
		$href = '';
		$href .= JURI::root();
		$href .= 'index.php?option=com_favorites&task=remove&format=raw&view=items';
		if (!empty($fid)) {
			$href .= '&fid=' . $fid;
		}
		if (!empty($object_id)) {
			$href .= '&oid=' . $object_id;
		}
		if (!empty($scope_id)) {
			$href .= '&sid=' . $scope_id;
		}
		if (!empty($name)) {
			$href .= '&n=' . $name;
		}
		if (!empty($url)) {
			$href .= '&u=' . $url;
		}

		return $href;
	}

}
