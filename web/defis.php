<?php

ob_start();

define('ENV',        'prod'); 
define('DOC_ROOT',   $_SERVER['DOCUMENT_ROOT']);
define('SYM_FOLD',   DOC_ROOT . '/symfony');
define('SYM_ROOT',   SYM_FOLD . '/lib');
define('PRJ_ROOT',   SYM_FOLD . '/prj');
define('CACHE_ROOT', PRJ_ROOT . '/cache');
define('APPS_ROOT',  PRJ_ROOT . '/apps');
define('DEFIS_ROOT', APPS_ROOT . '/defis');
define('MOD_ROOT',   DEFIS_ROOT . '/modules');
define('WEBDIR', SYM_FOLD . '/defis/');

require_once MOD_ROOT . '/helpersActions.php'; 
require_once(PRJ_ROOT . '/config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('defis', 'prod', false);
sfContext::createInstance($configuration)->dispatch();

ob_end_flush();