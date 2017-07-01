<?php

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

class Controller extends apstract {
 
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
        if ($this->_MODEL == null) {
            $this->_MODEL = new $name;
        }
        return $this->_MODEL;
    }

    /**
     * Load a Template
     * @param type string $name
     * @return \View
     */
    public function loadView($name) {
        if ($this->_VIEW == null) {
            $this->_VIEW = new View($name);
        }
         return $this->_VIEW;
    }

    /**
     * Load any plugin
     * @param type string Plugin name $name
     */
    public function loadPlugin($name) {
        require(APP_DIR . 'plugins/' . strtolower($name) . '.php');
    }

    /**
     * Load any Helper
     * @param type string Helpers name $name
     * @return \name
     */
    public function loadHelper($name) {
         if ($this->_HELPER == null) {
        $this->_HELPER = new $name;
         }
        return $this->_HELPER;
    }

    /**
     * Redirect to
     * @global type $config
     * @param type string location $loc
     */
    public function redirect($loc) {
        global $config;

        header('Location: ' . $config['base_url'] . $loc);
    }

    /**
     * Email Library
     * @return \PHPMailer
     */
    public function sendMail() {
        return new PHPMailer();
    }

    /**
     * Excel Library 
     * @return \PHPExcel
     */
    public function Excel() {
        return new PHPExcel();
    }

    /**
     *
     * @return \engine
     */
    public function Engine() {
        return new engine();
    }

}

?>