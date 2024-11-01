<?php

/*
 * Plugin Name: Simple Cookie Consents
 * Plugin URI: https://www.simpletools.nl
 * Description: Simple Cookie Consent is a lightweight wordpress plugin for alerting users about the use of cookies on your website. It is designed to help you quickly comply with the EU Cookie Law, CCPA, GDPR and other privacy laws. We made it fast, free, and relatively painless.
 * Author: SimpleTools.nl
 * Version: 1.0.0
 * */



if(is_admin()){

    require_once __DIR__.DIRECTORY_SEPARATOR.'simple_vars.php';

    require_once __DIR__.SIMPLETOOL_NL_DS.'plugin.php';
    $SimpleTools=SimpleToolsNlGDPRCookie::getInstance();


    $SimpleTools->setUserData();

	//if you are administrator, you can view the menu link
    $SimpleTools->addToAdminMenu();

}else{

    $cookie_name="simple_tools_nl_gdpr_cookie";
    if (!isset($_COOKIE[$cookie_name]) || $_COOKIE[$cookie_name]!= '1') {

        require_once __DIR__.DIRECTORY_SEPARATOR.'simple_vars.php';

        require_once __DIR__.SIMPLETOOL_NL_DS.'plugin.php';
        $SimpleTools=SimpleToolsNlGDPRCookie::getInstance();
        $SimpleTools->addGdprFiles();
        $SimpleTools->addGdprHTMlContent();

    }
}

?>