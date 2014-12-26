<?php
/*
 * Description of Class Model 
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
class Model extends db {

    public function __construct() {
        global $config;

        parent::__construct();
    }

    /**
     * Escapeing any string for the Db
     * @param $string string
     * @return type
     */
    public function escapeString($string) {
        return $this-> quote($string);
    }

    /**
     * Escapeing any string for the Db
     * @param $array with strings
     * @return array
     */
    public function escapeArray($array) {
        array_walk_recursive($array, create_function('&$v', '$v = $this->quote($v);'));
        return $array;
    }

    public function to_bool($val) {
        return !!$val;
    }

    /**
     * Get the corect datetime
     * @param $val a date
     * @return Date
     */
    public function to_date($val) {
        return date('d-m-Y', $val);
    }

    /**
     * Get back the correct time
     * @param $val timevalue
     * @return time
     */
    public function to_time($val) {
        return date('H:i:s', $val);
    }

    /**
     * Get back the correct DateTime
     * @param $val datetime
     * @return datetime
     */
    public function to_datetime($val) {
        return date('d-m-Y H:i:s', $val);
    }

}

?>
