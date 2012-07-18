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

Favorites::load('FavoritesModelBase','models.base');

class FavoritesModelDashboard extends FavoritesModelBase 
{
	function getTable()
	{
		JTable::addIncludePath( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_favorites'.DS.'tables' );
		$table = JTable::getInstance( 'Config', 'FavoritesTable' );
		return $table;
	}
}