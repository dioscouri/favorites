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
if (!class_exists('Tags')) {
	JLoader::register("Favorites", JPATH_ADMINISTRATOR . DS . "components" . DS . "com_favorites" . DS . "defines.php");
}

class FavoritesHelperFavorites extends JObject {

	public function addFavButton($object_id, $scope_id, $name, $url = null, $text = 'Add', $attribs = '') {
		$html = '';
		$html .= '<a id="fav' . $object_id . '-' . $scope_id . '" class="addFav favorites"';
		$html .= ' href="';
		$html .= $this -> makeurl($object_id, $scope_id, $name, $url);
		$html .= '">' . $text;
		$html .= '</a>';

		return $html;

	}

	public function removeFavButton($fid, $object_id, $scope_id, $name, $url = null, $text = 'remove', $attribs = '') {
		$html = ''; 
		$html .= '<a id="fav' . $object_id . '-' . $scope_id . '" class="removeFav favorites"';
		$html .= ' href="';
		$html .= $this -> removeurl($fid,$object_id, $scope_id, $name, $url);
		$html .= '">' . $text;
		$html .= '</a>';

		return $html;
	}

	public function favButton($object_id, $scope_id, $name, $url = null, $text = 'Add', $attribs = '') {

		$user = JFactory::getUser();
		if ($user -> id) {
			$model = DSCModel::getInstance('Items', 'FavoritesModel');
			if ($model -> checkItem('', $object_id, $scope_id, $name, $url, $user -> id)) {
				return $this -> addFavButton($object_id, $scope_id, $name, $url, $text , $attribs);
			} else {
				return $this -> removeFavButton('',$object_id, $scope_id, $name, $url, $text , $attribs);
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
	function removeurl($fid,$object_id, $scope_id, $name, $url = null) {

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
