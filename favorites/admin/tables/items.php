<?php
/**
 * @package	Favorites
 * @author 	Dioscouri Design
 * @link 	http://www.dioscouri.com
 * @copyright Copyright (C) 2007 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/
 
/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Restricted access' );


Favorites::load('FavoritesTable','tables.base');

class FavoritesTableItems extends FavoritesTable 
{

	function FavoritesTableItems( &$db ) 
	{
		$tbl_key 	= 'id';
		$tbl_suffix = 'items';
		$this->set( '_suffix', $tbl_suffix );
		$name 		= "favorites";
		
		parent::__construct( "#__{$name}_{$tbl_suffix}", $tbl_key, $db );	
	}
	
	
	
}