<?php
/**
* @package		Favorites
* @copyright	Copyright (C) 2009 DT Design Inc. All rights reserved.
* @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
* @link 		http://www.dioscouri.com
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

/*
JLoader::import( 'com_favorites.helpers.item', JPATH_ADMINISTRATOR.DS.'components' );
*/

class FavoritesController extends DSCControllerAdmin
{
    /**
    * default view
    */
    public $default_view = 'items';
}

?>