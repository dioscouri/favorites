<?php
/**
 * @package		Favorites
 * @copyright	Copyright (C) 2009 DT Design Inc. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link 		http://www.dioscouri.com
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
		$this -> registerTask('enabled.enable', 'boolean');
		$this -> registerTask('enabled.disable', 'boolean');

	}

	function _setModelState() {
		$state = parent::_setModelState();
		$app = JFactory::getApplication();
		$model = $this -> getModel($this -> get('suffix'));
		$ns = $this -> getNamespace();

		$state['filter_name'] = $app -> getUserStateFromRequest($ns . 'name', 'filter_name', '', '');
		$state['filter_id_from'] = $app -> getUserStateFromRequest($ns . 'name', 'filter_id_from', '', '');
		$state['filter_id_to'] = $app -> getUserStateFromRequest($ns . 'name', 'filter_id_to', '', '');
		$state['filter_userid'] = $app -> getUserStateFromRequest($ns . 'user_id', 'filter_userid', '', '');
		$state['filter_type'] = $app -> getUserStateFromRequest($ns . 'type', 'filter_type', '', '');
		$state['filter_url'] = $app -> getUserStateFromRequest($ns . 'url', 'filter_url', '', '');
		$state['filter_datecreated'] = $app -> getUserStateFromRequest($ns . 'datecreated', 'filter_datecreated', '', '');
		$state['filter_lastmodified'] = $app -> getUserStateFromRequest($ns . 'lastmodified', 'filter_lastmodified', '', '');
		$state['filter_enabled'] = $app -> getUserStateFromRequest($ns . 'enabled', 'filter_enabled', '', '');

		foreach (@$state as $key => $value) {
			$model -> setState($key, $value);
		}
		return $state;
	}

}
