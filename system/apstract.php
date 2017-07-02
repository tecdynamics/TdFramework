<?php
namespace system;
/*
 * Description of Class Abstract 
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
use application\helpers\Cookie;
use application\helpers\Crypto;

abstract class Apstract {  
    
    function loadModel(){}
    function loadView(){}
    function loadPlugin(){}
    function loadHelper(){}
   
    /**
     * Helper Function Cookies
     * Set , Get , Destroy any cookie
     * @return \CookieSet
     */
   final public function cookies() {
     //  require(APP_DIR . 'helpers/cookie.php');
          return new  Cookie();
    }

    /**
     * Helper Function 
     * For Crypt and decrypt anything
     * @return \Crypto
     */
    final public function Crypto() {
     //   require(APP_DIR . 'helpers/crypto.php');
       return new  Crypto();
    }

   
}
