<?php

/*
 * Description of Class Example Model 
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

class Example_model extends Model {

    public function getPdo($id = '') {
        $this->query('SELECT * FROM application');
        return $this->GetAll();
    }

    public function getOrm($id = '') {
        $ormData = $this->orm->application[1];
        return array($ormData["id"], $ormData["author_id"], $ormData["maintainer_id"], $ormData["title"], $ormData["web"], $ormData["slogan"]);
    }

}

?>
