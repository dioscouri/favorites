<?php
/**
 * @version    1.5
 * @package    Favorites
 * @author     Dioscouri Design
 * @link     http://www.dioscouri.com
 * @copyright Copyright (C) 2009 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.application.component.model' );

class modFavoritesHelper extends JObject
{
	 /**
     * Sets the modules params as a property of the object
     * @param unknown_type $params
     * @return unknown_type
     */
    function __construct( $params )
    {
        $this->params = $params;
    }
	
	function showAddbutton($url, $name) {
		
		$db = &JFactory::getDBO();
		$query = "select * from `#__favorites_items` where `name` = '{$name}' AND `url` = '{$url}'  limit 1";
		$db -> setQuery($query);
		$result = $db -> loadResult();

		if ($result) {
			return FALSE;
		} else {
			return TRUE ;
		}
	}
	
	
	/**
     * 
     * Enter description here ...
     * @return unknown_type
     */
    function getItems()
    {
        // Check the registry to see if our Schools class has been overridden
        if ( !class_exists('Favorites') )
        {
            JLoader::register( "Favorites", JPATH_ADMINISTRATOR . "/components/com_favorites/defines.php" );
        }
        
        Favorites::load( 'FavoritesConfig', 'defines' );
        
        JTable::addIncludePath( JPATH_ADMINISTRATOR . '/components/com_favorites/tables' );
    	JModel::addIncludePath( JPATH_ADMINISTRATOR . '/components/com_favorites/models' );

    	$model = JModel::getInstance( 'Items', 'FavoritesModel' );
       //set the user ID to THIS user
	   	$user = JFactory::getUser(); 
	    $filter_userid = $user->id;
	
		
    	if (!empty($filter_userid))
    	{
    	    $model->setState( 'filter_userid', $filter_userid );
    	}
        $layout = $this->params->get('layout', 'default' );
    	
    	//$model->setState( 'limit', $this->params->get('limit', '5' ) );
    	//$model->setState( 'order', 'tbl.createddate' );
    	//$model->setState( 'direction', 'DESC' );
       	$items = $model->getItems();
        
    	return $items;
    }
	
}
