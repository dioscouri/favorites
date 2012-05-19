<?php
/**
* @package		Favorites
* @copyright	Copyright (C) 2009 DT Design Inc. All rights reserved.
* @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
* @link 		http://www.dioscouri.com
*/


// no direct access
defined('_JEXEC') or die('Restricted access');


class Favorites extends DSC
{
	static $_version 		= '0.1.0';
    static $_copyrightyear 	= '2012';
    static $_min_php        = '5.2';

	
	/**
	 * constructor
	 * @return void
	 */
	function __construct() {
		parent::__construct();

		$this->setVariables();
	}
	
	/**
     * Get the copyright year
     */
    public static function getCopyrightYear()
    {
        return self::$_copyrightyear;
    }
	
	 /**
     * Intelligently loads instances of classes in framework
     *
     * Usage: $object = Mediamanager::getClass( 'MediamanagerHelperCarts', 'helpers.carts' );
     * Usage: $suffix = Mediamanager::getClass( 'MediamanagerHelperCarts', 'helpers.carts' )->getSuffix();
     * Usage: $categories = Mediamanager::getClass( 'MediamanagerSelect', 'select' )->category( $selected );
     *
     * @param string $classname   The class name
     * @param string $filepath    The filepath ( dot notation )
     * @param array  $options
     * @return object of requested class (if possible), else a new JObject
     */
    public static function getClass( $classname, $filepath='controller', $options=array( 'site'=>'admin', 'type'=>'components', 'ext'=>'com_favorites' )  )
    {
        return parent::getClass( $classname, $filepath, $options  );
    }
    
    /**
     * Method to intelligently load class files in the framework
     *
     * @param string $classname   The class name
     * @param string $filepath    The filepath ( dot notation )
     * @param array  $options
     * @return boolean
     */
    public static function load( $classname, $filepath='controller', $options=array( 'site'=>'admin', 'type'=>'components', 'ext'=>'com_favorites' ) )
    {
        return parent::load( $classname, $filepath, $options  );
    }
    
    
   
   

	/**
	 * Returns the query
	 * @return string The query to be used to retrieve the rows from the database
	 */
	function _buildQuery()
	{
		$query = "SELECT * FROM #__favorites_config";
		return $query;
	}

	
	/**
	 * Set Variables
	 *
	 * @acces	public
	 * @return	object
	 */
	function setVariables() {
		$success = false;

		if ( $data = $this->getData() )
		{
			for ($i=0; $i<count($data); $i++)
			{
				$title = $data[$i]->config_name;
				$value = $data[$i]->value;
				if (isset($title)) {
					$this->$title = $value;
				}
			}

			$success = true;
		}

		return $success;
	}

	/**
	 * Get component config
	 *
	 * @acces	public
	 * @return	object
	 */
	public static function getInstance() {
		static $instance;

		if (!is_object($instance)) {
			$instance = new Favorites();
		}

		return $instance;
	}
}
    
    
    