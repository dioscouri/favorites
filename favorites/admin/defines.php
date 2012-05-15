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
	
	public static function load( $classname, $filepath, $options=array( 'site'=>'admin', 'type'=>'components', 'ext'=>'com_favorites' ), $force = false ) 
    {
        $classname = strtolower( $classname );
    	if(version_compare(JVERSION,'1.6.0','ge')) {
            // Joomla! 1.6+ code here
            $classes = JLoader::getClassList();
        } else {
            // Joomla! 1.5 code here
            $classes = JLoader::register();
        }            

        if ( ( class_exists($classname) || array_key_exists( $classname, $classes ) ) && !$force )  
        {
            return true;
        }
        
        static $paths;

        if (empty($paths)) 
        {
            $paths = array();
        }
        
        if (empty($paths[$classname]) || !is_file($paths[$classname]))
        {
            // find the file and set the path
            if (!empty($options['base']))
            {
                $base = $options['base'];
            }
                else
            {
                // recreate base from $options array
                switch ($options['site'])
                {
                    case "site":
                        $base = JPATH_SITE.DS;
                        break;
                    default:
                        $base = JPATH_ADMINISTRATOR.DS;
                        break;
                }
                
                $base .= (!empty($options['type'])) ? $options['type'].DS : '';
                $base .= (!empty($options['ext'])) ? $options['ext'].DS : '';
            }
            
            $paths[$classname] = $base.str_replace( '.', DS, $filepath ).'.php';
        }
        
        // if invalid path, return false
        if (!is_file($paths[$classname]))
        {
            return false;
        }
        
        // if not registered, register it
        if ( !array_key_exists( $classname, $classes ) || $force ) 
        {
            JLoader::register( $classname, $paths[$classname] );
            return true;
        }
        return false;
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
    
    
    