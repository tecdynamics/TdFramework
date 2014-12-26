<?php

/*
 * Description of Class Error
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


class Error extends Controller {

    private $css = '';

    /**
     * @var the Exeptions msg 
     */
    static $_msg = '';

    public function index($error = '') {

        $this->error404();
        self::errorRecording($error);
    }

    /**
     * Render 404 Page for any regular error
     */
    public function error404() {

        $this->css = 'errors/css/error';
        $pageinfo = 'Error 404';
        ob_start();
        require(BASE . 'include/header.php');
        require(BASE . 'errors/error404.php');
        require(BASE . 'include/footer.php');
        echo ob_get_clean();
    }

    function dump_error_to_file($errno, $errstr) {
        self::errorRecording($errstr);
    }

    /**
     * Write into Log File
     * @param type $error sting
     */
    public static function errorRecording($error = '') {
        global $config;
        if ($config['errors'] === true) {
            $oldmask = umask(0);
            !file_exists(BASE . ERROR_PATH) ? mkdir(BASE . ERROR_PATH, 0777) : '';
            $handle = fopen(BASE . ERROR_PATH . '/' . ERROR_FILENAME, 'a+');
            $content = " |------------------------ Start at " . date('d-m-Y H:i:s') . " -------------------------------|\r\n";
            $content .= date('d-m-Y H:i:s') . " | Error Message " . $error . " \r\n";
            $content .=" |------------------------------- End -----------------------------------------|\r\n";
            fwrite($handle, $content);
            umask($oldmask);
            fclose($handle);
        }
    }

    /**
     * Main Exception Handler
     * @param Exception $e
     */
    public static function exception($e) {
        $d = new Exception();
        self::errorRecording($e);
        ob_start();
        require(BASE . 'errors/exception.php');
        echo ob_get_clean();
    }

    /**
     * Add more info in the Exception information
     * one msg at line error::apendMsg('this is your msg');
     * @param type $param string
     */
    public static function apendMsg($param = '') {
        $d = @unserialize(self::$_msg);
        @is_array($d) ? '' : $d = array();
        @array_push($d, $param);
        self::$_msg = @serialize($d);
    }

}
