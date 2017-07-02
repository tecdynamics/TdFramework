<?php
namespace system;
/*
 * Description of Class engine 
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
use \application\helpers\tdcashe\tdcashe;
 
class engine {

    private $gvars = array();
    private $pvars = array();
    private static $engeneInst = false;

    public static function getInstance(){
        $objs = null;
     if(self::$engeneInst === false){
       self::$engeneInst = new self;
     }
     $objs = &self::$engeneInst;
     $a = new Controller();
     $objs = &$a; 
     return $objs;
     
}


    /**
     * Get passed Variables
     * @return type array
     */
    public function getVars() {
        foreach ($_GET as $key => $val) {
            $this->gvars[self::escapeString($key)] = self::escapeString($val);
        }
        return $this->gvars;
    }

    /**
     * Get passed Variables
     * @return type array
     */
    public function postVars() {
        foreach ($_POST as $key => $val) {
            $this->pvars[self::escapeString($key)] = self::escapeString($val);
        }

        return $this->pvars;
    }

    /**
     * Cashing Read more at Helpers/tdcache
     * White Spaces and spesial characters
     * @param $val string
     * @return string
     */
    public static function Cashe() {
        
        return  tdcashe::getCasheObj();
    }

    /**
     * instantiate; set current page; set number of records
     * $pageNavi = engine::pagenavigation();
     * $pageNavi->setCrumbs(10); --> if you want to overwrite the default of 10 digits
     * $pageNavi->setTotal(600); -->your tottal records int
     * $template->set('pagenavig', $pageNavi->parse()); reneder you navigation into viriable
     * @return \Pagination
     */
    public static function pagenavigation() {
        // instantiate; set current page; set number of records
        $curentpage = isset($_GET['page']) ? ((int) $_GET['page']) : 1;
        $pgn = new \Pagination();
        $pgn->setCurrent($curentpage);
        // grab rendered/parsed pagination markup
        return $pgn;
    }

    /**
     * Escape a string  Not for db import
     * White Spaces and spesial characters
     * @param $val string
     * @return string
     */
    public static function escapeString($val = '') {
        if (!empty($val)) {
            $val = trim($val);
            $val = ltrim($val);
            $val = rtrim($val);
        } else {
            $val = '';
        }
        return !empty($val) ? $val : '';
    }

    /**
     * Escape An Array with Data Not for db import
     * White Spaces and spesial characters
     * @param $haystack array with data
     * @return array
     */
    public static function escapeArray($haystack = array()) {
        if (is_array($haystack)) {
            foreach ($haystack as $key => $value) {
                if (is_array($value)) {
                    $haystack[$key] = self::array_clean($value);
                } elseif (is_string($value)) {
                    $haystack[self::escapeString($key)] = self::escapeString($value);
                }
                if (!$value) {
                    unset($haystack[$key]);
                }
            }
        }
        return !empty($haystack) ? $haystack : '';
    }

    /**
     * Clean from the empty elements one multysesional 
     * Array 
     * @param type $arr array()
     * @return type array()
     */
    private static function array_clean($arr) {
        foreach ($arr as $key => $val) {
            if (!empty($val)) {
                $arr[self::escapeString($key)] = self::escapeString($val);
            } else {
                unset($arr[$key]);
            }
        }
        return !empty($arr) ? $arr : '';
    }

    /**
     * Debug System
     */
    public function debugScript() {
        echo '</br></br></br></br></br></br>'
        . '<div style="border:red solid thin; margin-left:60px; text-align=center;
            margin-right:60px; margin-top 30px; pading=5px;width:auto;
              height:auto;"> <pre> </br></br>
              Debug For the ' . __FILE__ . '</br></br>';
        var_dump(__FILE__, __LINE__, $_REQUEST);
        echo '</br></br>';
        print_r(debug_backtrace());
        echo '</pre></div>';
    }

}
