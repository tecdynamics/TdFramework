<?php

namespace system;

/*
 * Description of Class Controller 
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

use system\View;
use system\Model;
use system\engine;

class Controller extends Apstract {

    public function __call($func, $agr = '') {
        if (!function_exists($func)) {
            triggerError($func);
            exit;
        }
    }

    /**
     * Load a Model
     * @param type string Model Name $name
     * @return \name
     */
    public function loadModel($name) {
        if ($this->obj->_MODEL == null) {
            $this->obj->_MODEL = new $name;
        }
        return $this->obj->_MODEL;
    }

    /**
     * Load a Template
     * @param type string $name
     * @return \View
     */
    public function loadView($name) {
        if ($this->obj->_VIEW == null) {
            $this->obj->_VIEW = new View($name);
        }
        return $this->obj->_VIEW;
    }

    /**
     * Load any plugin
     * @param type string Plugin name $name
     */
    public function loadPlugin($name) {
        include_once (APP_DIR . 'plugins/' . strtolower($name) . '.php');
    }

    /**
     * Load any Helper
     * @param type string Helpers name $name
     * @return \name
     */
    public function loadHelper($name) {
        if ($this->obj->_HELPER == null) {
            $this->obj->_HELPER = new $name;
        }
        return $this->obj->_HELPER;
    }

    /**
     * Redirect to
     * @global type $config
     * @param type string location $loc
     */
    public function redirect($loc) {
        global $config;
        header('Location: ' . $config['base_url'] . $loc);
        exit;
    }

    /**
     * Email Library
     * @return \PHPMailer
     */
    public function sendMail() {
        include_once 'application/helpers/PHPMailer/class.phpmailer.php';
        return new \PHPMailer();
    }
    /**
     * Pagination Library
     * @return \Pagination
     */
    public function pagination() {
        include_once 'application/helpers/Pagination/Pagination.php';
        return new \Pagination();
    }

    /**
     * Excel Library 
     * @return \PHPExcel
     */
    public function Excel() {
        include_once 'application/helpers/phpexcel/PHPExcel.php';
        return new \PHPExcel();
    }

    /**
     *
     * @return \engine
     */
    public function Engine() {
        return new engine();
    }

}
