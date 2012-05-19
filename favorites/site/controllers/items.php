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
defined( '_JEXEC' ) or die( 'Restricted access' );

class FavoritesControllerItems extends FavoritesController
{
	/**
	 * constructor
	 */
	function __construct()
	{
		parent::__construct();

		$this->set('suffix', 'items');
		
		
	}

	/**
	 * Sets the model's state
	 *
	 * @return array()
	 */
	function _setModelState( $model_name='' )
	{
		$state = parent::_setModelState();
		$app = JFactory::getApplication();
		if (empty($model_name)) { $model_name = $this->get('suffix'); } 
		$model = $this->getModel( $model_name );
		$ns = $this->getNamespace();
		 $user = JFactory::getUser(); 
		$user_id = $user->id;
	
        if (!empty($user_id))
        {
           // use it
            $model->setState( 'filter_userid', $user_id);           
        } else {
        	//GUEST
        	// redirect to login probably
        }
		
		$state['filter_enabled']  = 1;      
        
		foreach (@$state as $key=>$value)
		{
			$model->setState( $key, $value );
		}

		return $state;
	
	}
	
	function display()
	{
        $view = $this->getView( 'items', 'html' );
		$view->set( '_doTask', true );
		$view->set( 'hidemenu', true );      

        JModel::addIncludePath( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_favorites'.DS.'models' );
	    $model = JModel::getInstance( 'Items', 'FavoritesModel' );
        
		
        $user = JFactory::getUser(); 
		$user_id = $user->id;
		
        if (!empty($user_id))
        {
            // use it
            $model->setState( 'filter_userid', $user_id);           
        } else {
        	// redirect to login probably
        }
        
        $query = $model->getQuery();
       // $query->group( 'tbl.type');
        $model->setQuery( $query );
        
        $app = JFactory::getApplication();
        $ns = $app->getName().'::'.'com.favorites.model.'.$model->getTable()->get('_suffix');

        $state = array();
		
	    foreach (@$state as $key=>$value)
        {
            $model->setState( $key, $value );
        }
  
		$params		= $app->getParams();
        $items = $model->getList();
	        $view->assign( 'items', $items );
		 $view->assign( 'params', $params );
        $view->setModel( $model );
        
        parent::display();
	}
}

?>