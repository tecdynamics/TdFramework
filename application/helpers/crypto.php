<?php
/*
 * Description of Helper Crypto 
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
class Crypto {
   
       /**
        * Encoding any string with mycript and base64
        * @param $string string
        * @return Encode string
        */   
    
    public static function crypt($string){ 
      $crypt=  mcrypt_encrypt(MCRYPT_RIJNDAEL_256, ENCODE_KEY, $string, MCRYPT_MODE_ECB);
      return base64_encode($crypt);
            
    }
    
       /**
        * Decoding any string with mycript and base64
        * @param $string the Encripted string
        * @return Decripted string
        */  
    public static function decrypt($decript_string){
    $string=base64_decode($decript_string);
return mcrypt_decrypt(MCRYPT_RIJNDAEL_256, ENCODE_KEY, $string, MCRYPT_MODE_ECB);  
    }
}
