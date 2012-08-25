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
    JLoader::register( "Favorites", JPATH_ADMINISTRATOR.DS."components".DS."com_favoritess".DS."defines.php" );
}

class FavoritesHelperFavorites extends JObject
{
	
}