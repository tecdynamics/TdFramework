<?php
/*
 * Description of Helper Session 
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
class Session_helper {
       
        /**
         * Set in the Session an array
         * @param type $key the key 
         * @param type $val the value
         */
	function set($key, $val)
	{
            if(!empty($key) && !empty($val)){
		$_SESSION[engine::escapeString($key)] = engine::escapeString($val);
            }
	}
	/**
         * Get from the Session a value
         * @param type $key the keyname
         * @return type array()
         */
	function get($key='')
	{ 
		return isset($_SESSION["$key"])?$_SESSION[$key]:null;
             
	}
	/**
         * Destroy all the sessions
         */
	function destroy()
	{
		session_destroy();
	}

}

?>