<?php

/*
 * Description of Class Rest
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

class Api {

    public $_action = null,
            $_func = '',
            $_allow = array(),
            $_content_type = "application/json",
            $_request = array(),
            $_method = "",
            $_code = 200;

    public function __construct() {
        $this->inputs();
    }

    /**
     * Return the REFERER
     * @return type
     */
    public function get_referer() {
        return $_SERVER['HTTP_REFERER'];
    }

    /**
     * Return the data or the error msg
     * @param type $data string
     * @param type $status any status check get_status_message()
     */
    public function response($data, $status) {
        $this->_code = ($status) ? $status : 200;
        $this->set_headers();
        if (is_array($data)) {
            print_r($data);
        } else {
            echo $data;
        }
        exit;
    }

    /**
     * All the error Msg
     * @return type string
     */
    private function get_status_message() {
        $status = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported');
        return ($status[$this->_code]) ? $status[$this->_code] : $status[500];
    }

    /**
     * Checking the REQUEST_METHOD
     * @return type 'GET,POST....'
     */
    public function get_request_method() {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Checkin if the request is XML
     * @param type $param
     * @return boolean
     */
    public function catchXML() {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            return TRUE;
        }
        return FALSE;
    }

    /**
     *
     */
    private function inputs() {
        switch ($this->get_request_method()) {
            case "POST":
                $this->_request = $this->cleanInputs($_POST);
                break;
            case "GET":
                $this->_request = $this->cleanInputs($_GET);
                break;
            case "DELETE":
                $this->_request = $this->cleanInputs($_GET);
                break;
            case "PUT":
                parse_str(file_get_contents("php://input"), $this->_request);
                $this->_request = $this->cleanInputs($this->_request);
                break;
            default:
                $this->response('', 406);
                break;
        }
    }

    /**
     * Checking and cleaning the iported data
     * @param type $data array or string
     * @return type clean data
     */
    private function cleanInputs($data) {
        $clean_input = array();
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $clean_input[$k] = $this->cleanInputs($v);
            }
        } else {
            if (get_magic_quotes_gpc()) {
                $data = trim(stripslashes($data));
            }
            $data = strip_tags($data);
            $clean_input = trim($data);
        }
        return $clean_input;
    }

    /**
     * Seting the Default Headers
     */
    private function set_headers() {
        header("HTTP/1.1 " . $this->_code . " " . $this->get_status_message());
        header("Content-Type:" . $this->_content_type);
    }

    /**
     * Main checker
     * @param type $method
     * @param type $args
     */
    public function __call($method, $args) {
        print_r($method);
    }

    /**
     * want to present the comments
     * stracture is on front @ the name of the field.
     * stracture is on front - the value of the field.
     * @param type $info string the Path of the file that you
     * @return type XML with all the Coments as description
     */
    public function getInfo($info) {
        $com = array();
        $comments = token_get_all(file_get_contents($info));
        $search = array('/', '*');
        foreach ($comments as $coment) {
            $messages = array();
            if ($coment[0] == T_COMMENT || $coment[0] == T_DOC_COMMENT) {
                $s = str_replace($search, '', $coment[1]);
                foreach (explode('@', $s) as $desc => $info) {
                    if (!empty($desc)) {
                        $in = explode('-', $info);
                        $messages[trim($in[0])] = trim($in[1]);
                    }
                }
            }
            if (!empty($messages)) {
                $com[] = $messages;
            }
        }
        return $this->response(json_encode($com), 200);
    }

    /*
     * @description -Generating an xml file for the response
     * @param type -$data array()
     * @return type -XML
     */

    public function createXml($data = array(), $code) {
        $xml = "<data>";
        $xml .="<content>";
        foreach ($data as $element) {
            $xml .="<content_data>";
            foreach ($element as $key => $val) {
                if (!empty($key)) {
                    $xml .= "<" . trim($key) . ">" . trim($val) . "</" . trim($key) . ">";
                }
            }
            $xml .="</content_data>";
        }
        $xml.="</content>";
        $xml.="</data>";
        $xmlobj = new SimpleXMLElement($xml);
        return $this->response($xmlobj->asXML(), $code);
    }

    /**
     * @description -Encode array into JSON
     * @param -type $data array
     * @return -type string
     */
    protected function json($data) {
        if (is_array($data)) {
            return json_encode($data);
        }
    }

}
