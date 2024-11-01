<?php defined('SIMPLETOOL_NL_WP_PLUGIN') or die('Restricted access');

foreach($_REQUEST as $k=>$v){
	$_REQUEST[$k]=trim(ltrim(rtrim($v)));
}

if(!current_user_can("administrator")){
	$_REQUEST['simpletools_nl_error']='This settings can be changed by Wordpress admins. Please login with your admin account and edit your lknSuite settings';
	require_once SIMPLETOOL_NL_ROOT.SIMPLETOOL_NL_DS.'task'.SIMPLETOOL_NL_DS.'settings.php';
	return;
}
	
	
if (!isset($_POST["simpletools_nl_admin_save_settins"]) || !wp_verify_nonce($_POST["simpletools_nl_admin_save_settins"], "save_settings.php")){
	$_REQUEST['simpletools_nl_error']='Please use the form instead of direct access to the form. We are not able to validate WP nonce field';
	require_once SIMPLETOOL_NL_ROOT.SIMPLETOOL_NL_DS.'task'.SIMPLETOOL_NL_DS.'settings.php';
	return;
}


$simple_gdpr_cookie_text=lknInputFilter::filterInput($_REQUEST,"simple_gdpr_cookie_text",'','RAW');
$simple_gdpr_cookie_text=ltrim(rtrim(trim($simple_gdpr_cookie_text)));
if($simple_gdpr_cookie_text==''){
	$_REQUEST['simpletools_nl_error']='Please make sure that you have written your "Cookie Information Text" ';
	require_once SIMPLETOOL_NL_ROOT.SIMPLETOOL_NL_DS.'task'.SIMPLETOOL_NL_DS.'settings.php';
	return;
}

$simple_gdpr_cookie_button_text=lknInputFilter::filterInput($_REQUEST,"simple_gdpr_cookie_button_text");
$simple_gdpr_cookie_button_text=ltrim(rtrim(trim($simple_gdpr_cookie_button_text)));
if($simple_gdpr_cookie_button_text==''){
	$_REQUEST['simpletools_nl_error']='Please make sure that you have written your "Cookie Confirmation Button Text" ';
	require_once SIMPLETOOL_NL_ROOT.SIMPLETOOL_NL_DS.'task'.SIMPLETOOL_NL_DS.'settings.php';
	return;
}


$data=array();
$data['simple_gdpr_cookie_button_text']=$simple_gdpr_cookie_button_text;
$data['simple_gdpr_cookie_text']=$simple_gdpr_cookie_text;

$sql=array();
$sql['ID']='1';
$sql['settings']=json_encode($data);
$sql['date_created']=time();


$lknsuite=SimpleToolsNlGDPRCookie::getInstance();
$lknsuite->getSettings();

$db=lknDb::getInstance();
$db->query($db->CreateInsertSql($sql,"#__simple_gdpr_settings",'REPLACE'));
$db->setQuery();


use phpFastCache\Helper\Psr16Adapter;

$Psr16Adapter = new Psr16Adapter("files");
$Psr16Adapter->clear();

lknredirect("admin.php?page=".SIMPLETOOL_NL_ADMIN_FILE_NAME,'Your settings are saved!')

?>