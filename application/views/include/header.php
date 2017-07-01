<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo $pagetitle; ?> </title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <link rel="shortcut icon" href="<?php echo BASE_IMAGE; ?>main/ico.ico" type="image/icon">
            <link rel="icon" href="<?php echo BASE_IMAGE; ?>main/ico.ico" type="image/icon">
                <!-- Latest compiled and minified CSS -->
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> 
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"> 
                        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" />
                        <?php
                        /** add Css Files * */
                        foreach (glob(BASE . 'css/*.css') as $cssfile) {
                            echo'<link href="' . VIEWS_CSS . $cssfile . '" rel="stylesheet" type="text/css" />';
                        }
                        if (isset($this->css)) {
                            echo' <link href="' . URL_PATH . $this->css . '.css" rel="stylesheet" type="text/css" />';
                        }
                        /** add Javascript Files* */
                        ?> 
                        <!-- Latest compiled and minified JavaScript -->
                        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
                        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/jquery-ui.min.js"></script>         
                        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
                        <?php
                        foreach (glob(BASE . 'js/*.js') as $jsfile) {
                            echo' <script type="text/javascript" src="' . VIEWS_CSS . $jsfile . '"></script> ';
                        }
                        if (isset($this->js)) {
                            echo' <script type="text/javascript" src="' . URL_PATH . $this->js . '.js"></script> ';
                        }
                        ?>
                        </head>
                        <body>
                            <div class="container">
                                
                                <nav class="navbar navbar-default " style="margin-top: 10px;">
                                    <div class="container-fluid">
                                        <div class="navbar-header">
                                            <h3>TEC DYNAMICS LTD</h3>
                                        </div>
                                        <ul class="nav navbar-nav navbar-right">
                                            <li class="active first"><a href="<?php echo BASE_URL; ?>home">Home</a></li>
                                            <li><a href="http://tecdynamics.co.uk">About Us</a></li>
                                            <li><a  href="<?php echo BASE_URL; ?>documentation">Documentation</a></li>

                                        </ul>
                                        
                                    </div>
                                </nav>
