<!--
 * Description of Class Controller
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
-->
<html>
    <header>
        <title>Tec - Dynamics Fatal Error </title></header>
    <style>
        .error_content{
            border:red solid thin;
            background: ghostwhite;
            vertical-align: middle;
            margin:0 auto;
            margin-top:50px;
            padding:10px;
            width: 70%;
            
        }
        .error_content label{color: red;font-family: Georgia;font-size: 16pt;font-style: italic;}
        .error_content ul li{ background: none repeat scroll 0 0 FloralWhite;
                              border: 1px solid AliceBlue;
                              display: block;
                              font-family: monospace;
                              padding: 2%;
                              text-align: left;
                              overflow-x: auto;
        }
    </style>
    <body style="text-align: center;">
        <div class="error_content">
            <label >Tec - Dynamics Fatal Error </label>
            <ul>
                <li><b>Line :</b><?php echo $d->getLine(); ?></li>
                <li><b>Message :</b><pre><?php print_r($e); ?></pre></li>
                <li><b>Trace :</b> <?php echo $d->getTraceAsString(); ?></li>
                <li><b>Costum Msg :</b> <?php echo $e->getMessage(); ?></li>
                <?php
                if (isset(self::$_msg)) {
                    foreach (@unserialize(self::$_msg) as $x => $msg) {
                        echo '<li><b>Extra Info ' . ($x + 1) . ' :</b> ' . $msg . '</li>';
                    }
                }
                ?>
            </ul> <a href="javascript:history.back()"> Back </a></div></body></html>
