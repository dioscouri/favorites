<?php

defined('_JEXEC') or die('Restricted access');

class FavoritesSelect extends DSCSelect {
	/**
	 *
	 * Enter description here ...
	 * @param $selected
	 * @param $name
	 * @param $attribs
	 * @param $idtag
	 * @param $allowAny
	 * @param $title
	 * @return unknown_type
	 */
	public static function type($selected, $name = 'filter_type', $attribs = array('class' => 'inputbox', 'size' => '1'), $idtag = null, $allowAny = false, $title = 'Select Type', $allowNone = false, $title_none = 'No Type') {
		$list = array();
		if ($allowAny) {
			$list[] = self::option('', "- " . JText::_($title) . " -");
		}

		$db = JFactory::getDbo();
		$query = "SELECT DISTINCT #__favorites_items.type  FROM #__favorites_items";
		$db -> setQuery($query);
		$types = $db -> loadObjectList();

		foreach ($types as $type) {
			$list[] = JHTML::_('select.option', strtolower($type -> type), $type -> type);
		}

		return self::genericlist($list, $name, $attribs, 'value', 'text', $selected, $idtag);
	}

	public static function users($selected, $name = 'filter_user_id', $attribs = array('class' => 'inputbox', 'size' => '1'), $idtag = null, $allowAny = false, $title = 'Select Type', $allowNone = false, $title_none = 'No Type') {
		$list = array();
		if ($allowAny) {
			$list[] = self::option('', "- " . JText::_($title) . " -");
		}

		// if ($allowNone)
		// {
		//     $list[] =  self::option( '0', "- ".JText::_( $title_none )." -" );
		// }
		/*
		 Now this is pretty useful, but this could get kinda slow if there are like 10k users that saved favorites, maybe it would be better to also store the username in the favs table for speed?
		 * atleast with this function we only get that users that have items
		 */
		// make this based on a table or some kind of plugin system
		$db = JFactory::getDbo();
		$query = "SELECT DISTINCT #__favorites_items.user_id, #__users.username FROM #__favorites_items INNER JOIN #__users ON #__favorites_items.user_id = #__users.id";
		$db -> setQuery($query);
		$users = $db -> loadObjectList();

		foreach ($users as $user) {
			$list[] = JHTML::_('select.option', $user -> user_id, $user -> username);
		}

		return self::genericlist($list, $name, $attribs, 'value', 'text', $selected, $idtag);
	}

}
