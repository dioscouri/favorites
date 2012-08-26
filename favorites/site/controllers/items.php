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
        	//TODO redirect to login probably, should not let a user that is not logged in request this list. 
        }
		
		$state['filter_enabled']  = 1;      
        
		foreach (@$state as $key=>$value)
		{
			$model->setState( $key, $value );
		}

		return $state;
	
	}
	
	function display($cachable=false, $urlparams = false)
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
        	// redirect to login probably,  shouldn't even need this really i think should be be don'e already in the model
        }
        
        
        $app = JFactory::getApplication();
        $ns = $app->getName().'::'.'com.favorites.model.'.$model->getTable()->get('_suffix');

        $state = array();
		
	    foreach (@$state as $key=>$value)
        {
            $model->setState( $key, $value );
        }
  
		$params		= $app->getParams();
        $list = $model->getList();
		
	    $view->assign( 'items', $list );
		$view->assign( 'params', $params );
        $view->setModel( $model );
        
        parent::display($cachable, $urlparams);
	}

	function grab_dump($var)
{
    ob_start();
    var_dump($var);
    return ob_get_clean();
}

	function add() {
		
		$user = JFactory::getUser();
		
		if($user->id){
			//Check for posted/getVars
			$name = urldecode(JRequest::getVar('n'));
			$url = urldecode(JRequest::getVar('u'));	
			$object_id = JRequest::getVar('oid');
			$scope_id = JRequest::getVar('sid');
			$date = new JDate();
			//get the model
			$model = DSCModel::getInstance('Items','FavoritesModel');
			if($model->checkItem('', $object_id, $scope_id, $name, $url, $user->id  )){
			
			//OK we are good to add the new object
			$table = DSCTable::getInstance('Items', 'FavoritesTable');
			$table -> load();
			$table -> object_id = @$object_id;
			$table -> scope_id = @$scope_id;
			$table -> name = $name;
			$table -> user_id = $user -> id;
			$table -> url = $url;
			//unset things that are not params, and store everything else
			
			$table -> datecreated = $date -> toMySQL();
			$table -> enabled = '1';
			
			if($table -> store()) {
				$html = "Favorite Added";
				$success = 'TRUE';
			} else {
				$success = 'FALSE';
			}	
				
				
			}
			
			
		} else {
			//not logged in
			$html = "Not authenicated";
				$success = 'FLASE';
		}
		
		$response = array();
        $response['msg'] = $html;
		$response['success'] = $success;
		
        echo ( json_encode( $response ) );
		
	}



	public function addFavorite() {
		$date = new JDate();
		$user = JFactory::getUser();
		
		// this is kind of annoying trying to support submint both forms and not forms  maybe we should just  make one single method
		/*
		 *  like  what if the url would contain all the info. 
		 * 
		 * like /index.php?option=com_favorites&task=addFavorite&format=raw&view=items&name=Something%20Like&url=http://something.com&scope_id=3&object_id=4
		 * 
		 * And we just make a helper that addeds the links, all the add buttons being anchor tags
		 * 
		 * we can than just have really simple javacript to just post to the url, and high itself on success.
		 * 
		 */
		
		$elements = json_decode(preg_replace('/[\n\r]+/', '\n', JRequest::getVar('elements', '', 'post', 'string')));
		$helper = new DSCHelper();
		$values = $helper -> elementsToArray($elements);

		// real quick test to see if we already have this, here mostly to avoid double click double posting
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		if ($user -> id == 0) {
			return FALSE;
		}
		
		$model = DSCModel::getInstance('Items','FavoritesModel');

		$result = $model -> checkItem(@$values['object_id'], $values['url'], $values['name'], $values['id'], $values['scope_id'], $user->id  );
		
		if ($result) {
			$html = "Favorite already exists";
			$success = 'FALSE';
		} else {
			$table = DSCTable::getInstance('Items', 'FavoritesTable');
			$table -> load();
			$table -> object_id = @$values['object_id'];
			$table -> scope_id = @$values['scope_id'];
			$table -> name = $values['name'];
			$table -> user_id = $user -> id;
			$table -> url = $values['url'];
			//unset things that are not params, and store everything else
			unset($values['name']);
			unset($values['object_id']);
			unset($values['scope_id']);
			unset($values['url']);
			unset($values['type']);
			unset($values['add_type']);
			unset($values['add_new_favorite']);
			unset($values['_checked']);
			foreach ($values as $name => $value) {
				$values[(string)$name] = (string)$value;
			}
			$insertParams = json_encode($values);

			$table -> params = $insertParams;
			$table -> datecreated = $date -> toMySQL();
			$table -> enabled = '1';
			//$dump = $this->grab_dump($values);
			if($table -> store()) {
				$html = "Favorite Added";
				$success = 'TRUE';
			} else {
				$success = 'FALSE';
			}

		}
		$response = array();
        $response['msg'] = $html;
		$response['success'] = $success;
		
        echo ( json_encode( $response ) );	
		
	}

	public function removeFavorite($plugin) {
		$date = new JDate();

		$elements = json_decode(preg_replace('/[\n\r]+/', '\n', JRequest::getVar('elements', '', 'post', 'string')));
		$helper = new DSCHelper();
		$values = $helper -> elementsToArray($elements);

		//
		if ($values['id']) {
			$favorite = JTable::getInstance('Items', 'FavoritesTable');
			$favorite -> delete($values['id']);
			return 'Favorite removed';
		} else {
			return 'Favorite not removed';
		}

	}




}

?>