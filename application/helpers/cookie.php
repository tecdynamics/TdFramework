<?php
namespace application\helpers;
/*
 * Description of Class TdCookie 
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

class Cookie {
 

   /**
    * Set Session Start
    */
    public function init() {
        @session_start();
    }

    /**
     * Seting a new Cookie
     * @param string Name of the cookie $value
     * @param string Value of the  $secondValue 
     */
    public function setCookie($value, $secondValue) {
        setcookie('uid', $secondValue, time() + 3600, '/');
        setcookie('user', $value, time() + 3600, '/');         
    }
    

    /**
     * Get Back any cookie
     * @param type the name of the cookie $name
     * @return the cookie or false
     */
    public function getCookie($name='user') {
        if (isset($_COOKIE[$name])) {

            return $_COOKIE[$name];
            
        } else {
            self::destroyCookie();
             
            return false;
        }
    }

   /**
    * Deastory any cookies
    * @return type bool
    */
    public function destroyCookie() {
                $past = time()- 23600;
                        foreach ( $_COOKIE as $key => $value )
                        {
                            setcookie( $key, $value, $past, '/' );
                        }
       return isset($_SERVER['HTTP_COOKIE'])?false:true;
    }

}
