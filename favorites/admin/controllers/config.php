<?php
/**
* @package		Favorites
* @copyright	Copyright (C) 2009 DT Design Inc. All rights reserved.
* @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
* @link 		http://www.dioscouri.com
*/

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Restricted access' );

class FavoritesControllerConfig extends FavoritesController 
{
	/**
	 * constructor
	 */
	function __construct() 
	{
		parent::__construct();
		
		$this->set('suffix', 'config');
	}
	
	/**
	 * save a record
	 * @return void
	 */
	function save() 
	{
		$error = false;
		$errorMsg = "";
		$model 	= $this->getModel( $this->get('suffix') );
		$config = Favorites::getInstance();
		$properties = $config->getProperties();

		foreach (@$properties as $key => $value ) 
		{
			unset($row);
			$row = $model->getTable( 'config' );
			$newvalue = JRequest::getVar( $key );
			$value_exists = array_key_exists( $key, $_POST );
			if ( $value_exists && !empty($key) ) 
			{ 
				// proceed if newvalue present in request. prevents overwriting for non-existent values.
				$row->load( array('config_name'=>$key) );
				$row->config_name = $key;
				$row->value = $newvalue;
				
				if ( !$row->save() ) 
				{
					$error = true;
					$errorMsg .= JText::_( "Could not store")." $key :: ".$row->getError()." - ";	
				}
			}
		}
		
		if ( !$error ) 
		{
			$this->messagetype 	= 'message';
			$this->message  	= JText::_( 'Saved' );
			
			$dispatcher = JDispatcher::getInstance();
			$dispatcher->trigger( 'onAfterSave'.$this->get('suffix'), array( $row ) );
		} 
			else 
		{
			$this->messagetype 	= 'notice';			
			$this->message 		= JText::_( 'Save Failed' )." - ".$errorMsg;
		}
		
    	$redirect = "index.php?option=com_favorites";
    	$task = JRequest::getVar('task');
    	switch ($task)
    	{
    		default:
    			$redirect .= "&view=".$this->get('suffix');
    		  break;
    	}

    	$redirect = JRoute::_( $redirect, false );
		$this->setRedirect( $redirect, $this->message, $this->messagetype );
	}
	
}

?>