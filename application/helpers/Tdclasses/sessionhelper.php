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
class SessionHelper {

    /**
         * Set in the Session an array
         * @param type $key the key 
         * @param type $val the value
         */
	public static function set($key, $val) {
            if (!empty($key) && !empty($val)) {
            if (is_array($val) || is_object($val)) {
                $_SESSION['tecSession'][engine::escapeString($key)] = json_encode($val);
            } else {
                $_SESSION['tecSession'][engine::escapeString($key)] = engine::escapeString($val);
            }
        }
        return $val;
    }
	/**
         * Get from the Session a value
         * @param type $key the keyname
         * @return type array()
         */
	public static function get($key = '') {
	if (isset($_SESSION['tecSession'][engine::escapeString($key)])) {
            $session = $_SESSION['tecSession'][engine::escapeString($key)];
            if (Urlhelper::isJson($session)) {
                return json_decode($session);
            } else {
                return $session;
            }
        }
        return null;
    }

    /**
         * Destroy all the sessions
         */
	public static function destroy($key = null) {
        if ($key == null) {
            session_destroy();
        } else {
            unset($_SESSION['tecSession'][$key]);
        }
    }

    public static function encodeSession($id = 0) {
        return md5('tecSession' . $id);
    }

}
 