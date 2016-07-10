<?php
/*
 * Description of Helper Url
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
class Urlhelper {

    private static $_GLOBAL_LANG = array(
        'af', // afrikaans.
        'ar', // arabic.
        'bg', // bulgarian.
        'ca', // catalan.
        'cs', // czech.
        'da', // danish.
        'de', // german.
        'el', // greek.
        'en', // english.
        'es', // spanish.
        'et', // estonian.
        'fi', // finnish.
        'fr', // french.
        'gl', // galician.
        'he', // hebrew.
        'hi', // hindi.
        'hr', // croatian.
        'hu', // hungarian.
        'id', // indonesian.
        'it', // italian.
        'ja', // japanese.
        'ko', // korean.
        'ka', // georgian.
        'lt', // lithuanian.
        'lv', // latvian.
        'ms', // malay.
        'nl', // dutch.
        'no', // norwegian.
        'pl', // polish.
        'pt', // portuguese.
        'ro', // romanian.
        'ru', // russian.
        'sk', // slovak.
        'sl', // slovenian.
        'sq', // albanian.
        'sr', // serbian.
        'sv', // swedish.
        'th', // thai.
        'tr', // turkish.
        'uk', // ukrainian.
        'el', // greek.
        'zh' // chinese.
    );

    /**
     * get the base url
     * @global type $config
     * @return string
     */
    public static function base_url() {
		global $config;
		return $config['base_url'];
	}
        /**
     * Detect browsers default lang
     * @global type $config
     * @return string
     */
    public static function get_url_lang() {
        global $config;
        if ($_SERVER["HTTP_ACCEPT_LANGUAGE"] != "") {
             $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
             return (isset(self::$_GLOBAL_LANG[$lang])) ? self::$_GLOBAL_LANG[$lang] : $config['defLang'];
        }
        return $config['defLang'];
    }
    /**
     *
     * @param type $seg
     * @return boolean
     */
    public static function segment($seg) {
		if(!is_int($seg)) return false;
	$parts = explode('/', $_SERVER['REQUEST_URI']);
        return isset($parts[$seg]) ? $parts[$seg] : false;
	}

    /**
     * Checking the string is valid json format
     * @param string $string
     * @return bool
     */
    public static function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

}

?>