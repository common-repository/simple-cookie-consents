<?php

defined('SIMPLETOOL_NL_WP_PLUGIN') or die('Restricted access');


require_once SIMPLETOOL_NL_LIBRARY.SIMPLETOOL_NL_DS.'psr'.SIMPLETOOL_NL_DS.'cache'.SIMPLETOOL_NL_DS.'CacheException.php';
require_once SIMPLETOOL_NL_LIBRARY.SIMPLETOOL_NL_DS.'psr'.SIMPLETOOL_NL_DS.'cache'.SIMPLETOOL_NL_DS.'CacheItemInterface.php';
require_once SIMPLETOOL_NL_LIBRARY.SIMPLETOOL_NL_DS.'psr'.SIMPLETOOL_NL_DS.'cache'.SIMPLETOOL_NL_DS.'CacheItemPoolInterface.php';
require_once SIMPLETOOL_NL_LIBRARY.SIMPLETOOL_NL_DS.'psr'.SIMPLETOOL_NL_DS.'cache'.SIMPLETOOL_NL_DS.'InvalidArgumentException.php';


require_once SIMPLETOOL_NL_LIBRARY.SIMPLETOOL_NL_DS.'psr'.SIMPLETOOL_NL_DS.'simple-cache'.SIMPLETOOL_NL_DS.'CacheException.php';
require_once SIMPLETOOL_NL_LIBRARY.SIMPLETOOL_NL_DS.'psr'.SIMPLETOOL_NL_DS.'simple-cache'.SIMPLETOOL_NL_DS.'CacheInterface.php';
require_once SIMPLETOOL_NL_LIBRARY.SIMPLETOOL_NL_DS.'psr'.SIMPLETOOL_NL_DS.'simple-cache'.SIMPLETOOL_NL_DS.'InvalidArgumentException.php';


require_once SIMPLETOOL_NL_LIBRARY.SIMPLETOOL_NL_DS.'cache'.SIMPLETOOL_NL_DS.'src'.SIMPLETOOL_NL_DS.'autoload.php';


use phpFastCache\Core\phpFastCache;
use phpFastCache\Helper\Psr16Adapter;


class SimpleToolsNlGDPRCookie{
	
	private $_db;
	private $_db_prefix_mask;
	
	private $simple_tools_nl_actions;
	
	private $_post_params;
	
	
	public $_vars;
	
	
	function __construct(){
		$this->import();
		
		global $wpdb;
		
		
		$this->_db            = &$wpdb;
		$this->_db_prefix_mask="#__";
		
		require_once SIMPLETOOL_NL_ROOT.SIMPLETOOL_NL_DS.'plugin_actions.php';
		
		$this->simple_tools_nl_actions=SimpleToolsNlGDPRCookieActions::getInstance();
		$this->_vars=array();
  
	}
	
	
	function get($var){
		if(isset($this->$var)){
			return $this->$var;
		}else{
			return null;
		}
	}
	
	
	/**
	 *
	 * @return SimpleToolsNlGDPRCookie
	 */
	public static function getInstance(){
		static $_instance;
		if(!isset($_instance)){
			$_instance=new SimpleToolsNlGDPRCookie();
		}
		
		return $_instance;
		
	}
	
	
	private function import(){
		
		require_once SIMPLETOOL_NL_LIBRARY.SIMPLETOOL_NL_DS.'phpinputfilter'.SIMPLETOOL_NL_DS.'phpinputfilter.inputfilter.php';
		
		require_once SIMPLETOOL_NL_LIBRARY.SIMPLETOOL_NL_DS.'lknlibrary'.SIMPLETOOL_NL_DS.'registery.php';
		require_once SIMPLETOOL_NL_LIBRARY.SIMPLETOOL_NL_DS.'lknlibrary'.SIMPLETOOL_NL_DS.'class.template.php';
		require_once SIMPLETOOL_NL_LIBRARY.SIMPLETOOL_NL_DS.'lknlibrary'.SIMPLETOOL_NL_DS.'class.user.php';
		require_once SIMPLETOOL_NL_LIBRARY.SIMPLETOOL_NL_DS.'lknlibrary'.SIMPLETOOL_NL_DS.'functions.php';
		require_once SIMPLETOOL_NL_LIBRARY.SIMPLETOOL_NL_DS.'lknlibrary'.SIMPLETOOL_NL_DS.'class.db.php';
	}
	
	function setUserData(){
		add_action('init',array($this->simple_tools_nl_actions,'setUserData'));
	}
	
	function addToAdminMenu(){
		add_action('admin_menu',array($this->simple_tools_nl_actions,'addToAdminMenu'));
	}

    function addGdprFiles(){
        add_action('wp_enqueue_scripts',array($this->simple_tools_nl_actions,'addheader'));
    }


    function addGdprHTMlContent(){
        add_action('wp_footer',array($this->simple_tools_nl_actions,'GdprHTMlContent'));
    }

	function getAdminPage(){
		
		ob_clean();
		
		ob_start(); // Start output buffering
		$this->error();
		require_once SIMPLETOOL_NL_ROOT.SIMPLETOOL_NL_DS.SIMPLETOOL_NL_ADMIN_FILE_NAME;
		
		$contents=ob_get_contents(); // Get the contents of the buffer
		ob_end_clean(); // End buffering and discard
		
		
		return $contents;
	}
	
	
	function loadParams(){
		
		
		$row=$this->getSettings();
		
		if(isset($row->settings) && $row->settings!=''){
			
			$this->_post_params=json_decode($row->settings);
		}else{
			$this->_post_params='';
		}
		
	}
	
	private function createTable(){

		$db=lknDb::getInstance();
		$db->query("CREATE TABLE IF NOT EXISTS `#__simple_gdpr_settings` (
  `ID` tinyint(1) NOT NULL,
  `settings` mediumtext NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
		$db->setQuery();

		
		$db->query("ALTER TABLE `#__simple_gdpr_settings` ADD UNIQUE KEY `ID` (`ID`)");
		$db->setQuery();

		
		$sql                =array();
		$sql['ID']          ='1';
		$sql['settings']    ='';
		$sql['date_created']=time();
		
		$db->query($db->CreateInsertSql($sql,"#__simple_gdpr_settings",'REPLACE'));
		$db->setQuery();
		
		return $this->getSettings();
	}
	
	
	function getSettings(){
		
		$Psr16Adapter=new Psr16Adapter("files");

		$keyword='settings';
		
		if(!$Psr16Adapter->has($keyword)){
			$db=lknDb::getInstance();
			$db->query("SELECT * FROM #__simple_gdpr_settings WHERE ID='1'");
			$db->setQuery();

			if($db->getErrorMessage()!=''){
				return $this->createTable();
			}else{
				$row=$db->loadObject();
				$Psr16Adapter->set($keyword,$row,3600);
			}

		}else{
			// Getter action
			$row=$Psr16Adapter->get($keyword);
		}
		
		return $row;
	}
	
	

	
	function getPostParam($param){
		if(isset($this->_post_params->$param)){
			return $this->_post_params->$param;
		}else{
			return '';
		}
	}

	
	
	function error(){
		
		
		$error=lknStripSlash(lknInputFilter::filterInput($_REQUEST,'simpletools_nl_error'));
		$msg  =lknStripSlash(lknInputFilter::filterInput($_REQUEST,'simpletools_nl_msg'));
		
		
		if($error!='' || $msg!=''){
			?>
			<?php if($error!=''){ ?>
                <p align="center" id="simpletools_nl_errormessage">

                    <div class="error settings-error notice is-dismissible" id="">
                <p><strong><?php echo $error; ?></strong></p>
                <button type="button" class="notice-dismiss"><span class="screen-reader-text">Hide</span>
                </button>
                </div>

                </p>
				<?php
			}elseif($msg!=''){
				
				?>
                <p align="center" id="lknsuite_infomessage">
                    <div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible">
                <p><strong><?php echo $msg; ?></strong></p>
                <button type="button" class="notice-dismiss"><span class="screen-reader-text">Hide</span>
                </button>

                </div>

                </p>
				
				<?php
			}
			?>
			
			<?php
		}
	}
}

?>