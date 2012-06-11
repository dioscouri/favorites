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

$app = JFactory::getApplication();
$uri = JFactory::getURI();
$doc = JFactory::getDocument();
if($params->get('showremovelinks')) {
$url =  $uri->getPath();
} else {
$url = $uri->toString(); ; 
	
}


$name = $doc->getTitle();
$replace = $params->get('replace');
if(!empty($replace)) {
$name = str_replace($replace, '', $name);
}

$addButton = FALSE;
if($params->get('showaddlink')) {
$addButton =  $helper->showAddbutton($url, $name);
}
$removeButton = $params->get('showremovelinks');
$user = JFactory::getUser(); 
	

if($user->id == '0') {
	 require( JModuleHelper::getLayoutPath( 'mod_favorites', 'login'  ) );
} else {
	 require( JModuleHelper::getLayoutPath( 'mod_favorites', $params->get( 'layout', 'default' ) ) );
}




?>