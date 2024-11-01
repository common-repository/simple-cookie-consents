<?php defined('SIMPLETOOL_NL_WP_PLUGIN') or die('Restricted access');



$tmpl=lknTemplate::getInstance();
$tmpl->setIsAdmin(1);


$SimpleToolsNl=SimpleToolsNlGDPRCookie::getInstance();
$row=$SimpleToolsNl->getSettings();

if(isset($row->settings) && $row->settings!=''){
	$row=json_decode($row->settings);
}


$simple_gdpr_cookie_button_text=lknInputFilter::filterInput($_REQUEST,"simple_gdpr_cookie_button_text");
if($simple_gdpr_cookie_button_text=='' && !isset($_POST['simple_gdpr_cookie_button_text'])){
	$default='OK';
	$simple_gdpr_cookie_button_text=(isset($row->simple_gdpr_cookie_button_text)?$row->simple_gdpr_cookie_button_text:$default);
}


$simple_gdpr_cookie_text=lknInputFilter::filterInput($_REQUEST,"simple_gdpr_cookie_text");
if($simple_gdpr_cookie_text=='' && !isset($_POST['simple_gdpr_cookie_text'])){
	$default='We use cookies to improve our service for you. You can find more information from our <a href="CHANGE_THIS_WITH_YOUR_PRIVACY_POLICY_URL">privacy policy</a>';
	$simple_gdpr_cookie_text=(isset($row->simple_gdpr_cookie_text)?$row->simple_gdpr_cookie_text:$default);
}

$tmpl->set('simple_gdpr_cookie_button_text',lknStripSlash($simple_gdpr_cookie_button_text));
$tmpl->set('simple_gdpr_cookie_text',lknStripSlash($simple_gdpr_cookie_text));


echo $tmpl->fetch_view("settings");
?>
