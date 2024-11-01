<?php

if(!defined('SIMPLETOOL_NL_DS')){
    define('SIMPLETOOL_NL_WP_PLUGIN','1');

    define('SIMPLETOOL_NL_DS',DIRECTORY_SEPARATOR);
    define("SIMPLETOOL_NL_ROOT",__DIR__);
    define("SIMPLETOOL_NL_LIBRARY",__DIR__.SIMPLETOOL_NL_DS.'lknlibrary');

    //something like http://www.sitename.com/sub-directory/another-subdirectory/wp-content/plugins/simple_gdpr
    define("SIMPLETOOL_NL_BASE_PATH",plugins_url().'/'. basename(__DIR__) );

    define("SIMPLETOOL_NL_ADMIN_FILE_NAME",'simple_gdpr_admin.php');


}

?>