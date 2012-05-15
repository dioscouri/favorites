<?php 

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

// Check the registry to see if our Favorites class has been overridden
if ( !class_exists('Favorites') ) 
{
    JLoader::register( "Favorites", JPATH_ADMINISTRATOR . "/components/com_favorites/defines.php" );
}
    
require_once( dirname(__FILE__).DS.'helper.php' );

$helper = new modFavoritesHelper( $params ); 
$items = $helper->getItems();

$app =& JFactory::getApplication();
$document =& JFactory::getDocument();

/*JTable::addIncludePath( JPATH_ADMINISTRATOR . '/components/com_favorites/tables' );
JModel::addIncludePath( JPATH_ADMINISTRATOR . '/components/com_favorites/models' );

$model = JModel::getInstance( 'Items', 'FavoritesModel' );
$table = JTable::getInstance( 'Items', 'FavoritesTable' );
*/
if (empty($items))
{
    require( JModuleHelper::getLayoutPath( 'mod_favorites', 'none' ) );
} 
    else
{
    require( JModuleHelper::getLayoutPath( 'mod_favorites', $params->get( 'layout', 'default' ) ) );
}


?>