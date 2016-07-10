<?php

/*
 * Description of Class config 
 * Copyright (c) 2013 - 2014 Tec-Dynamics 
 * 
 * This Framework is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details. 
 * @category   PHP 
 * @package    Framework
 * @copyright  Copyright (c) 2013 - 2014 Tec-Dynamics L.T.D. (http://www.tec-dynamics.co.uk/webphp)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    0.1.5, 2014-12-22  
 */
// Web Site Info
$config['base_url'] = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST']; // Base URL including trailing slash (e.g. http://localhost/)
$config['errors'] = False;  // Enable error recording True/False
$config['costum_errors'] = true; // Enable Costum Error recording True/False
$config['default_controller'] = 'home'; // Default controller to load
$config['default_action'] = 'index'; // Default controller to load
$config['error_controller'] = 'error'; // Controller used for errors (e.g. 404, 500 etc)
$config['encodekey'] = 'TecDynamics!@123';  // The main Encoding Key Case Sensitive.
$config['pagetitle'] = 'Tec-Dynamics | Framework';  // The main Pages Title.
$config['defLang'] = 'en';  // Default language e.g. [en --English-- , el --Greek--  more info helpers/Tdclasses/Urlhelper].

/**
 * -------------- Defines please do not edit -----------------------
 */
define('ROOT_DIR', realpath(dirname(__FILE__)) . '/');
define('APP_DIR', 'application/');
define('BASE', 'application/views/');
define('VIEWS_URL', $config['base_url'] . 'application/views/');
define('VIEWS_CSS', $config['base_url'] . '');
define('BASE_URL', $config['base_url']);
define('BASE_IMAGE', $config['base_url'] . '/' . BASE . 'images/');
define('URL_PATH', $config['base_url'] . 'application/');
define('CASHE_PATH', 'tmp/');
define('ENCODE_KEY', $config['encodekey']);
/**
 * ----------- if you want to relocate the error logs ---------------
 */
define('ERROR_PATH', 'errors/logs'); //@var the actual path of the logs
define('ERROR_FILENAME', 'error.log'); //@var the actual filename of the logs

/*
 * --------------- Error Info ----------------------
 * 0 - Turn off all error reporting
 * 1 - Running errors
 * 2 - Running errors + notices
 * 3 - All errors except notices and warnings
 * 4 - All errors except notices
 * 5 - All errors
 */
$php_error_reporting = 2;
define('DEBUG_ENABLED', false); //Enable disable Debug Mode True/False


switch ($php_error_reporting) {
    case 0: error_reporting(0);
        break;
    case 1:
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
        ini_set('display_errors', 1);
        break;
    case 2:
        error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
        ini_set('display_errors', 1);
        break;
    case 3:
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        ini_set('display_errors', 1);
        break;
    case 4:
        ini_set('display_errors', 0);
        error_reporting(E_ALL ^ E_NOTICE);
        break;
    case 5:
        error_reporting(E_ALL);
        break;
    default:
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
}

