<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo $pagetitle; ?> </title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="shortcut icon" href="<?php echo BASE_IMAGE; ?>main/ico.ico" type="image/icon">
            <link rel="icon" href="<?php echo BASE_IMAGE; ?>main/ico.ico" type="image/icon">
                <?php
                /** add Css Files * */
                echo' <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" />';
                foreach (glob(BASE . 'css/*.css') as $cssfile) {
                    echo'<link href="' . VIEWS_CSS . $cssfile . '" rel="stylesheet" type="text/css" />';
                }
                if (isset($this->css)) {
                    echo' <link href="' . URL_PATH . $this->css . '.css" rel="stylesheet" type="text/css" />';
                }
                /** add Javascript Files* */
                echo ' <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
         <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/jquery-ui.min.js"></script>';
                foreach (glob(BASE . 'js/*.js') as $jsfile) {
                    echo' <script type="text/javascript" src="' . VIEWS_CSS . $jsfile . '"></script> ';
                }
                if (isset($this->js)) {
                    echo' <script type="text/javascript" src="' . URL_PATH . $this->js . '.js"></script> ';
                }
                ?>
                </head>
                <body>
                    <div id="wrapper">
                        <div class="menuzone">
                            <div class="topMenu">
                                <ul>
                                    <li class="first"><a href="<?php echo BASE_URL; ?>home">Home</a></li>
                                    <li><a   href="<?php echo BASE_URL; ?>about">About Us</a></li>
                                    <li><a  href="<?php echo BASE_URL; ?>contact">Contact Us</a></li>
                                </ul>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="clear"></div>
                        <div id="header">
                            <div id="logo"></div>
                           