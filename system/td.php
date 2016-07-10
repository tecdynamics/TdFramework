<?php

function autoload($className) {

     $paths = array(
                    'application/controllers',
                    'application/models',
                    'system/'
     );
     $helpers = array_filter(glob('application/helpers/*'), 'is_dir');
     $plugins = array_filter(glob('application/plugins/*'), 'is_dir');
     $folders = @array_merge($helpers, $plugins);
   
    $array_edit = function ($val, $key = '') use(&$paths) {
          foreach ($val as $key => $vars) {
               if(!empty($vars)) {
                    $paths[] = $vars;
               }
          }
     };
    foreach ($folders as $key => $extrafile) {
          $internalfolders[] = array_filter(glob($extrafile . '/*'), 'is_dir');
          array_filter($internalfolders);
     }

     array_walk($internalfolders, $array_edit);

     $paths = array_merge($paths, $folders);

     $filenames = array(
                    '%s.php',
                    '%s.class.php',
                    'class.%s.php',
                    '%s.inc.php',
                    '%s_controller.php',
                    '%s.smtp.php'
     );

     $path = str_ireplace('_', '/', strtolower($className));
              if (@include_once $path . '.php') {
        return;
     }
    foreach ($paths as $dirs) {
          foreach ($filenames as $filename) {
               $searchedpath = $dirs . '/' . sprintf($filename, strtolower($className));
             if (file_exists($searchedpath)) {
                @require_once($searchedpath);
                return;
               }
          }
     }

}

spl_autoload_register('autoload');

