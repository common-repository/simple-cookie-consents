<?php

defined('SIMPLETOOL_NL_WP_PLUGIN') or die('Restricted access');


class SimpleToolsNlGDPRCookieActions
{

    function __construct()
    {
    }


    /**
     *
     * @return SimpleToolsNlGDPRCookieActions
     */
    public static function getInstance()
    {
        static $_instance;
        if (!isset($_instance)) {
            $_instance = new SimpleToolsNlGDPRCookieActions();
        }

        return $_instance;
    }


    function setUserData()
    {
        global $current_user;

        if (isset($current_user->ID)) {

            $user = lknUser::getInstance();
            $user->set('id', $current_user->ID);
            $user->set('email', $current_user->user_email);
            $user->set('name', $current_user->user_nicename);
            $user->set('username', $current_user->user_login);
            $user->set('registerDate', $current_user->user_registered);
            $user->set('lastvisitDate', $current_user->last_activity);
            $user->set('my', $current_user);
            $user->set('usertype', $current_user->roles);

        }
    }


    /**
     * Register a custom menu page.
     */
    function addToAdminMenu()
    {
        add_menu_page('Simple GDPR Cookie', 'Simple GDPR Cookie', 'manage_options', "simple_gdpr_admin.php", array(
            $this,
            'adminPage'
        ));
    }


    function adminPage()
    {
        require_once SIMPLETOOL_NL_ROOT . SIMPLETOOL_NL_DS . SIMPLETOOL_NL_ADMIN_FILE_NAME;
        return;
    }

    function addheader()
    {
        wp_enqueue_script('jquery');
        wp_enqueue_script('simple_tools_nl_gdpr_js', SIMPLETOOL_NL_BASE_PATH . '/front/html.js', array(), false, true);
        wp_enqueue_style('simple_tools_nl_gdpr_css', SIMPLETOOL_NL_BASE_PATH . '/front/html.css');
    }

    function GdprHTMlContent()
    {

        $SimpleToolsNl = SimpleToolsNlGDPRCookie::getInstance();
        $row = $SimpleToolsNl->getSettings();

        if (isset($row->settings) && $row->settings != '') {
            $row = json_decode($row->settings);
        }


        $default = 'OK';
        $simple_gdpr_cookie_button_text = ((isset($row->simple_gdpr_cookie_button_text) && $row->simple_gdpr_cookie_button_text!='') ? $row->simple_gdpr_cookie_button_text : $default);


        $default = 'We use cookies to improve our service for you. You can find more information from our <a href="CHANGE_THIS_WITH_YOUR_PRIVACY_POLICY_URL">privacy policy</a>';
        $simple_gdpr_cookie_text = ((isset($row->simple_gdpr_cookie_text) && $row->simple_gdpr_cookie_text!='') ? $row->simple_gdpr_cookie_text : $default);


        $file = __DIR__ . SIMPLETOOL_NL_DS . 'front' . SIMPLETOOL_NL_DS . 'html.html';
        $text = file_get_contents($file);
        $text=str_replace('{SIMPLE_TOOLS_NL_GDPR_COOKIE_TEXT}',$simple_gdpr_cookie_text,$text);
        $text=str_replace('{SIMPLE_TOOLS_NL_GDPR_COOKIE_BUTTON_TEXT}',$simple_gdpr_cookie_button_text,$text);

        echo $text;
    }

    function get($var)
    {
        if (isset($this->$var)) {
            return $this->$var;
        } else {
            return null;
        }
    }

}

?>