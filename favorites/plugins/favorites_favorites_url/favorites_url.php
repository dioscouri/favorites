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

Favorites::load('FavoritesPluginBase', 'library.plugin.base');

class plgFavoritesFavorites_Url extends FavoritesPluginBase {
		
	public $_element = 'favorites';
	public $dot_path_prefix = 'favorites_url.';
	public $path_prefix = 'favorites_url/';
	public $plain_name = 'FavoriteUrl';
	public $full_path = '';
	public $relative_path = '';

	function __construct(&$subject, $config) {
		parent::__construct($subject, $config);
		
		// Get the application object.
		$app = JFactory::getApplication();

		// was getting a Jmodel Error when using the admin not sure why
		if (!$app->isAdmin()){
		JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_favorites/tables');
		JModel::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_favorites/models');
		}
	}

	public function addNewFavorite($plugin) {
		$date = new JDate();
		$user = JFactory::getUser(); 
		$elements = json_decode(preg_replace('/[\n\r]+/', '\n', JRequest::getVar('elements', '', 'post', 'string')));
		$helper = new DSCHelper();
		$values = $helper -> elementsToArray($elements);

		// real quick test to see if we already have this, here mostly to avoid double click double posting
		$db = &JFactory::getDBO();
		$user = JFactory::getUser();
		if($user->id == 0) {return FALSE;}
		$query = "select * from `#__favorites_items` where `type` = '{$values['type']}' `name` = '{$values['name']}' AND `url` = '{$values['url']}' AND `user_id` = '{$user->id}'  limit 1";
		$db -> setQuery($query);
		$result = $db -> loadResult();

		if ($result) {
			// do someelse better than this
			return 'Favorite already exists';
		} else {
			$newFavorite = JTable::getInstance('Items', 'FavoritesTable');
			$newFavorite -> load();
			$newFavorite -> type = $values['type'];
			$newFavorite -> name = $values['name'];
			$newFavorite -> user_id = $user->id;
			$newFavorite -> url = $values['url'];
			//unset things that are not params, and store everything else
			unset($values['name']);
			unset($values['url']);
			unset($values['type']);
			unset($values['add_type']);
			unset($values['add_new_favorite']);
			unset($values['_checked']);
			foreach ( $values as $name => $value ) {
			$values[ (string) $name ] = (string) $value;
			}
			$insertParams = json_encode($values);
			
			$newFavorite -> params = $insertParams;
			$newFavorite -> datecreated = $date -> toMySQL();
			$newFavorite -> enabled = '1';
			$newFavorite -> store();
		}

		//TODO make sure this is true
		return 'Favorite Added';
	}

	public function removeFavorite($plugin) {
		$date = new JDate();

		$elements = json_decode(preg_replace('/[\n\r]+/', '\n', JRequest::getVar('elements', '', 'post', 'string')));
		$helper = new DSCHelper();
		$values = $helper -> elementsToArray($elements);
		
		// 
		if ($values['add_type'] == 'removeFavorite' && $values['id']) {
			$favorite = JTable::getInstance('Items', 'FavoritesTable');
			$favorite -> delete($values['id']);
			return 'Favorite removed';
		} else {
			return 'Favorite not removed';
		}

	}

}
