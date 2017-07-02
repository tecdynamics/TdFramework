<?php
namespace system;
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
 */

class Bootstrap extends Controller {

    function __construct() {
        global $config;
        $controller = $config['default_controller'];
        set_exception_handler('exception');
        if ($config['costum_errors'] === true) {
            set_error_handler('dump_error_to_file');
        }
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = explode('/', strtolower(rtrim($url)));
        $RequestedFile = $url[0];
        $this->cookies()->init();
        if (empty($url[0])) {
            $c = 'application\controllers\\'.$config['default_controller'];
            $controller = new $c;
            $controller->{$config['default_action']}();
            return;
        } else {
            if (!file_exists(APP_DIR . 'controllers/' . $RequestedFile . '.php')) {
                triggerError($url);
                return;
            } else {
                $c = 'application\controllers\\'.$RequestedFile;
                  $controller = new $c;
                //==================
                if (!empty($url[2])) {
                    $controller->{$url[1]}($url[2]);
                    return;
                } else
                if ((!empty($url[1])) && (Is_numeric($url[1]))) {
                    $controller->index($url[1]);
                    return;
                } elseif (!empty($url[1])) {
                    if (method_exists($controller, $url[1])) {
                        $controller->{$url[1]}();
                    } else {
                        triggerError($url);
                    }
                    return;
                }
                $controller->index();
            }
        }
    }

}
