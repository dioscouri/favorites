<?php
/**
* @package		Favorites
* @copyright	Copyright (C) 2009 DT Design Inc. All rights reserved.
* @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
* @link 		http://www.dioscouri.com
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

class FavoritesViewBase extends DSCViewAdmin
{
	/**
	 * Displays a layout file 
	 * 
	 * @param unknown_type $tpl
	 * @return unknown_type
	 */
	function display($tpl=null)
	{
        
        Favorites::load( 'DSCGrid', 'library.grid' );
		 Favorites::load( 'FavoritesSelect', 'library.select' );
		/*
        Favorites::load( 'FavoritesMenu', 'library.menu' );
        Favorites::load( 'FavoritesUrl', 'library.url' );
       
		*/
		
		
		parent::display($tpl);
	}

	
}