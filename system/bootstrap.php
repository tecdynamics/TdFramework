<?php

/*
 * Description of Class Bootstrap 
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
 *

  $request_url = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';
  $script_url  = (isset($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : '';
  // Get our url path and trim the / of the left and the right
  if($request_url != $script_url) $url = trim(preg_replace('/'. str_replace('/', '\/', str_replace('index.php', '', $script_url)) .'/', '', $request_url, 1), '/');
  //	// Split the url into segments
  $segments1 = explode('?', $url);

  $segments = explode('/', $segments1[0]);
  //	// Do our default checks
  if(isset($segments[0]) && $segments[0] != '') $controller = $segments[0];
  if(isset($segments[1]) && $segments[1] != '') $action = $segments[1];
 * 
  //	// Create object and call method
  $obj = new $controller;
  die(call_user_func_array(array($obj, $action), array_slice($segments, 2)));

 */

class Bootstrap {

    function __construct() {
        global $config;
        $controller = $config['default_controller'];
        set_exception_handler(array('Error', 'exception'));
        if ($config['costum_errors'] === true) {
            set_error_handler(array('Error', 'dump_error_to_file'));
        }
        
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url);
        $url = explode('/', $url);
        $RequestedFile = strtolower($url[0]);
        Cookie::init();
        if (empty($url[0])) {
            $controller = $controller = $config['default_controller']::getInstance();

            $controller->{$config['default_action']}();
            return FALSE;
        } else {
            if (!file_exists(APP_DIR . 'controllers/' . $RequestedFile . '.php')) {
                $controller = Error::getInstance();
                $controller->index($RequestedFile);
                return FALSE;
            } else {
                $controller = $RequestedFile::getInstance();
              
                //==================
                if (!empty($url[2])) {
                    $controller->{$url[1]}($url[2]);
                    return false;
                } else
                if ((!empty($url[1])) && (Is_numeric($url[1]))) {
                    $controller->index($url[1]);
                    return false;
                } elseif (!empty($url[1])) {
                    if (method_exists($controller, $url[1])) {
                        $controller->{$url[1]}();

                    } else {
                        $controller = Error::getInstance();
                        $controller->Index($url[1]);
                    }
                    return FALSE;
                }
                $controller->index();
            }
        }
    }

}
