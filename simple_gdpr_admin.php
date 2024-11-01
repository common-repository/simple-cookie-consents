<?php defined('SIMPLETOOL_NL_WP_PLUGIN') or die('Restricted access'); ?>
<?php

$task=lknInputFilter::filterInput($_REQUEST,"task",'settings');
$file=SIMPLETOOL_NL_ROOT.SIMPLETOOL_NL_DS.'admin'.SIMPLETOOL_NL_DS.'task'.SIMPLETOOL_NL_DS.$task.'.php';
if(file_exists($file)){
	require_once $file;
}else{
	echo "<h1>Task is not found</h1>";
}
?>
