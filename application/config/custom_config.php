<?php

/* 
 *  ****************************************************************
 *  *** DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER. ***
 *  ****************************************************************
 *  Copyright © 2016 TEC-Dynamics LTD <support@tecdynamics.org>.
 *  All rights reserved.
 *  This software contains confidential proprietary information belonging
 *  to Tec-Dynamics Software Limited. No part of this information may be used, reproduced,
 *  or stored without prior written consent of Tec-Dynamics Software Limited.
 *  @Author    : Michail Fragiskos
 *  @Created at: 25-Jun-2016
 *  @File      : custom_config.php 
 */

/**
 * ---------------- Database Info -----------------------
 */
$config['db_type'] = 'mysql'; // Database type *Mysql*Sql*
$config['db_name'] = ''; // Database name
$config['db_username'] = ''; // Database username
$config['db_password'] = ''; // Database password
$config['db_host'] = 'localhost'; // Database host (e.g. localhost)

/**
 * --------Email Vars -----------------------
 */
define('SMTPemailAuth', 'true');
define('EmailPort', '25'); //465
define('EmailHost', 'mail.yourSmtp.com'); //smtp.gmail.com
define('SMTPEmailSecure', false); // 'ssl');
define('mailUsername', 'email@youremail.com'); //yourgmail@gmail.com
define('mailPassword', 'yourPassword');
define('Fromemail', 'your@email.com');
define('FromNamemail', 'Your Name');
