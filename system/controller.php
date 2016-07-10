<?php

ini_set('display_errors', 1);
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

    protected $model = false;
    protected $helper = false;
    //protected $view = false;
    private static $_lang = false;
    private static $_Instance = false;

    public static function getInstance() {
        if (self::$_Instance == false) {
            self::$_Instance = new static();
        }
        return self::$_Instance;
    }

    private function __construct() {
//        if (self::$_lang == false) {
//            self::$_lang = self::getLang();
//        }
    }

    public function __call($func, $agr = '') {
        if (!function_exists($func)) {
            $template = $this->loadView('errors/error404');
            $template->addStyle('errors/css/error');
            $template->set('page', 'Error 404');
            $template->render();
            exit;
        }
    }

    /**
     * Load a Model
     * @param type string Model Name $name
     * @return \name
     */
    public function loadModel($className = '') {
        $name = str_ireplace('_', '/', strtolower($className));
        $class = explode('_', $className);
        if (is_array($class) && file_exists(APP_DIR . '/models/' . $name . '.php')) {
            require_once APP_DIR . '/models/' . $name . '.php';
            $this->model = new $class[count($class) - 1];
        } else if (file_exists(APP_DIR . '/models/' . $className . '.php')) {
            $this->model = new $className;
        } else {
            return;
        }

        return $this->model;
    }

    /**
     * Load a Template
     * @param type string $name
     * @return \View
     */
    public function loadView($name = '') {
        //if (file_exists(BASE . $name)) {
        $view = new View($name);
        //  }
        ob_start();
        return $view;
        ob_clean();
    }

    /**
     * Load any plugin
     * @param type string Plugin name $name
     */
    public function loadPlugin($name = '') {
        if (file_exists(APP_DIR . 'plugins/' . strtolower($name) . '.php')) {
            require(APP_DIR . 'plugins/' . strtolower($name) . '.php');
        }
    }

    /**
     * Load any Helper
     * @param type string Helpers name $name
     * @return \name
     */
    public function loadHelper($name) {
        if (file_exists(APP_DIR . 'plugins/' . strtolower($name) . '.php')) {
            $this->helper = new $name;
        }
        return $this->helper;
    }

    /**
     * Redirect to
     * @global type $config
     * @param type string location $loc
     */
    public function redirect($loc = '') {
        global $config;

        !empty($loc) ? header('Location: ' . $config['base_url'] . $loc) : '';
    }

    /**
     * get browser default lang
     * @return obj
     */
    public static function getLang() {
        if (self::$_lang == false) {
            $langDetect = Urlhelper::get_url_lang();
           // $newLang = !empty($langDetect) ? $langDetect : 'en';
            require APP_DIR . 'lang/' . $langDetect . '.php';
            self::$_lang = (object) $lang;
        }
        return self::$_lang;
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
     * get the engine
     * @return \engine
     */
    public function Engine() {
        return new engine();
    }

    private function __wakeup() {

    }

    private function __clone() {

    }

}

?>