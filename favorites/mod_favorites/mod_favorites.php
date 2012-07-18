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

/* this is if want the user to be able to remove their links*/
if($params->get('showremovelinks')) {
$url =  $uri->getPath();
} else {
$url = $uri->toString(); ; 
	
}

/* The module stores by default the title of page, this allows the  developer of the site to remove a string from the title, like - domain.org*/
$name = $doc->getTitle();
$replace = $params->get('replace');
if(!empty($replace)) {
$name = str_replace($replace, '', $name);
}

/* If the module is set to show the add button, run the check to see if the page is already added for this user if not use the add button.*/
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