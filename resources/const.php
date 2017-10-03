<?php

defined("HEADER")
    or define('HEADER', realpath(dirname(__FILE__)). '/templates/header.php');

defined("SIDENAV")
   or  define('SIDENAV', realpath(dirname(__FILE__)). '/templates/mainsidebar.php');

defined('STOCK')
   or  define('STOCK', dirname(dirname(__FILE__)).  '/stock');

defined("WEB_ROOT")
   or  define('WEB_ROOT', realpath(dirname(__FILE__)). '../../stock/new.php');

// defined("VIEW_STOCK")
//    or  define('VIEW_STOCK', realpath(dirname(__FILE__)). '../../stock/view.php');




  ini_set('error_reporting', true);
   error_reporting("E_ALL|E_STRICT") ;
   // set_error_handler(handleError);



function handleError(){
	echo "Error Occured";
}


    // define('SIDENAV', $_SERVER['DOCUMENT_ROOT'] . '/resources/templates/mainsidebar.php');

    // // define('FOOTER', $_SERVER['DOCUMENT_ROOT'] . '/resources/templates/header.php');
    // define('RESOURCES', $_SERVER['DOCUMENT_ROOT'] . '/resources/templates/header.php');
    // define('HOME', $_SERVER['DOCUMENT_ROOT']);

    
?>