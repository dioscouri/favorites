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

class FavoritesControllerItems extends FavoritesController {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this -> set('suffix', 'items');

	}

	/**
	 * Sets the model's state
	 *
	 * @return array()
	 */
	function _setModelState($model_name = '') {
		$state = parent::_setModelState();
		$app = JFactory::getApplication();
		if (empty($model_name)) { $model_name = $this -> get('suffix');
		}
		$model = $this -> getModel($model_name);
		$ns = $this -> getNamespace();
		$user = JFactory::getUser();
		$user_id = $user -> id;

		if (!empty($user_id)) {
			// use it
			$model -> setState('filter_userid', $user_id);
		} else {
			//GUEST
			// redirect to login probably
		}

		$state['filter_enabled'] = 1;

		foreach (@$state as $key => $value) {
			$model -> setState($key, $value);
		}

		return $state;

	}

	function display($cachable = false, $urlparams = false) {
		$view = $this -> getView('items', 'html');
		$view -> set('_doTask', true);
		$view -> set('hidemenu', true);

		JModel::addIncludePath(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_favorites' . DS . 'models');
		$model = JModel::getInstance('Items', 'FavoritesModel');

		$user = JFactory::getUser();
		$user_id = $user -> id;

		if (!empty($user_id)) {
			// use it
			$model -> setState('filter_userid', $user_id);
		} else {
			// redirect to login probably
		}

		$app = JFactory::getApplication();
		$ns = $app -> getName() . '::' . 'com.favorites.model.' . $model -> getTable() -> get('_suffix');

		$state = array();

		foreach (@$state as $key => $value) {
			$model -> setState($key, $value);
		}

		$params = $app -> getParams();
		$list = $model -> getList();

		$view -> assign('items', $list);
		$view -> assign('params', $params);
		$view -> setModel($model);

		parent::display($cachable, $urlparams);
	}

	public function addFavorite() {
		$date = new JDate();
		$user = JFactory::getUser();
		$elements = json_decode(preg_replace('/[\n\r]+/', '\n', JRequest::getVar('elements', '', 'post', 'string')));
		$helper = new DSCHelper();
		$values = $helper -> elementsToArray($elements);

		// real quick test to see if we already have this, here mostly to avoid double click double posting
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		if ($user -> id == 0) {
			return FALSE;
		}

		$model = DSCModel::getInstance('Items', 'FavoritesModel');

		$result = $model -> checkItem(@$values['object_id'], $values['url'], $values['name'], $values['id'], $values['type'], $user -> id);

		if ($result) {
			$html = "Favorite already exists";
			$success = 'FALSE';
		} else {
			$newFavorite = DSCTable::getInstance('Items', 'FavoritesTable');
			$newFavorite -> load();
			$newFavorite -> object_id = @$values['object_id'];
			$newFavorite -> scope_id = @$values['scope_id'];
			$newFavorite -> type = $values['type'];
			$newFavorite -> name = $values['name'];
			$newFavorite -> user_id = $user -> id;
			$newFavorite -> url = $values['url'];
			//unset things that are not params, and store everything else
			unset($values['name']);
			unset($values['object_id']);
			unset($values['scope_id']);
			unset($values['url']);
			unset($values['type']);
			unset($values['add_type']);
			unset($values['add_new_favorite']);
			unset($values['_checked']);
			foreach ($values as $name => $value) {
				$values[(string)$name] = (string)$value;
			}
			$insertParams = json_encode($values);

			$newFavorite -> params = $insertParams;
			$newFavorite -> datecreated = $date -> toMySQL();
			$newFavorite -> enabled = '1';

			if ($newFavorite -> store()) {
				$html = "Favorite Added";
				$success = 'TRUE';
			} else {
				$success = 'FALSE';
			}

		}
		$response = array();
		$response['msg'] = $html;
		$response['success'] = $success;
		echo( json_encode($response));

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
?>