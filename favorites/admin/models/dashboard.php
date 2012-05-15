<?php
/**
 * @version	1.5
 * @package	Favorites
 * @author 	Dioscouri Design
 * @link 	http://www.dioscouri.com
 * @copyright Copyright (C) 2007 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

JLoader::import( 'com_favorites.models._base', JPATH_ADMINISTRATOR.DS.'components' );

class FavoritesModelDashboard extends FavoritesModelBase 
{
	function getTable()
	{
		JTable::addIncludePath( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_favorites'.DS.'tables' );
		$table = JTable::getInstance( 'Config', 'FavoritesTable' );
		return $table;
	}
}