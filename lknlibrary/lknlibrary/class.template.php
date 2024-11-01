<?php

defined('SIMPLETOOL_NL_WP_PLUGIN') or die('Restricted access');

class lknTemplate{
	
	private $vars;
	private $is_admin;
	
	private $_filename;
	
	/**
	 * Constructor
	 *
	 */
	function __construct(){
	    $this->is_admin=0;
	
	}


    /**
     * @param int $is_admin
     */
    public function setIsAdmin($is_admin)
    {
        $this->is_admin = $is_admin;
    }
	
	/**
	 * @return lknTemplate
	 */
	
	public static function getInstance(){
		static $_instance;
		if(!isset($_instance)){
			$_instance=new lknTemplate();
		}
		
		return $_instance;
	}
	
	
	// Prevent users to clone the instance
	public final function __clone(){
		trigger_error('Clone is not allowed.',E_USER_ERROR);
		exit('No Clone');
	}
	
	/**
	 * Set a template variable.
	 */
	function set($name,$value){
		$this->vars[$name]=$value;
	}
	
	
	function setMasterTemlateFile($name){
		$this->_filename=$name;
	}
	
	/**
	 * returns a template variable. if $name does not exist, returns null
	 *
	 * @param $name
	 *
	 * @return null
	 */
	
	function get($name){
		
		return isset($this->vars[$name])?$this->vars[$name]:null;
	}
	
	

	function fetch_view($filename){
		
		
		if ($this->is_admin==0){
            $file=SIMPLETOOL_NL_ROOT.SIMPLETOOL_NL_DS.'front'.SIMPLETOOL_NL_DS.'views'.SIMPLETOOL_NL_DS.$filename.'.php';
        }else{
            $file=SIMPLETOOL_NL_ROOT.SIMPLETOOL_NL_DS.'admin'.SIMPLETOOL_NL_DS.'views'.SIMPLETOOL_NL_DS.$filename.'.php';
        }
		
		
		if(!file_exists($file)){
			return "View is not found";
		}
		
		if($this->vars){
			extract($this->vars,EXTR_REFS); // Extract the vars to local namespace
		}
		
		ob_start(); // Start output buffering
		SimpleToolsNlGDPRCookie::getInstance()->error();
		require($file); // Include the file
		$contents=ob_get_contents(); // Get the contents of the buffer
		ob_end_clean(); // End buffering and discard
		
		return $contents; // Return the contents
	}
	
	
}

?>