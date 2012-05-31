<?php
/**
* All requests routed through here. This is an overview of what actually happens during a request.
*
* @package LydiaCore
*/

/**
* PHASE: BOOTSTRAP
*/
define('LYDIA_INSTALL_PATH', dirname(__FILE__));
define('LYDIA_SITE_PATH', LYDIA_INSTALL_PATH.'/site');
require(LYDIA_INSTALL_PATH.'/src/CLydia/bootstrap.php');
$ly = CLydia::instance();

/**
* PHASE: FRONTCONTROLLER ROUTE
*/
$ly->FrontControllerRoute();

/**
* PHASE: THEME ENGINGE RENDER
*/
$ly->ThemeEngineRender();