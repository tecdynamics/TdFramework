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
 

      $css = '';

    /**
     * @var the Exeptions msg 
     */
     $_msg = '';

     function triggerError($error = '') {
     
        error404();
        if(!empty($error)){
        errorRecording($error);
     }}

    /**
     * Render 404 Page for any regular error
     */
    function error404() { 
        $template = new View('errors/error404');
        $template->set('css', 'errors/css/error');
        $template->set('pageinfo', 'Error 404');
        $template->render();  
    }

    function dump_error_to_file($errstr='') {
        errorRecording($errstr);
    }

    /**
     * Write into Log File
     * @param type $error sting
     */
    function errorRecording($error = '') {
        global $config;
        if ((bool)$config['errors'] === true) {
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
  function exception($e='') {
        $d = new Exception();
         errorRecording($e);
        ob_start();
        require(BASE . 'errors/exception.php');
        echo ob_get_clean();
    }

    /**
     * Add more info in the Exception information
     * one msg at line error::apendMsg('this is your msg');
     * @param type $param string
     */
      function apendMsg($param = '') {
        $d = @unserialize($_msg);
        @is_array($d) ? '' : $d = array();
        @array_push($d, $param);
         $_msg = @serialize($d);
    }
 
