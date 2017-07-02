<?php

class Autoloader {

    private $paths = array(
        //'application/controllers',
        //'application/models',
        'system',
        'application',
    );
    private $filenames = array(
        '%s.php',
        '%s.class.php',
        'class.%s.php',
        '%s.inc.php',
        '%s_controller.php',
        '%s.smtp.php'
    );

    public static function loader($className) {
        $l = new self;
        $helpers = array_filter(glob('application/helpers/*'), 'is_dir');
        $plugins = array_filter(glob('application/plugins/*'), 'is_dir');
        $folders = @array_merge($helpers, $plugins);

        $array_edit = function($val, $key = '') use (&$paths) {
            foreach ($val as $key => $vars) {
                if (!empty($vars)) {
                    $paths[] = $vars;
                }
            }
        };

        foreach ($folders as $extrafile) {
            $internalfolders[] = array_filter(glob($extrafile . '/*'), 'is_dir');
            array_filter($internalfolders);
        }

        array_walk($internalfolders, $array_edit);

        $paths = array_merge($l->paths, $folders); 
         $clazz = str_replace("\\", "/", $className);
         
        $namespace = str_replace("\\", "/", __NAMESPACE__);
        
        $path = (empty($namespace) ? '' : $namespace . "/") . "{$clazz}.php";
        
        
          if (@include_once strtolower($path)) {
             return;
        }  
        
       if (file_exists(strtolower($path))) {
             @include_once strtolower($path);
            return;
        }
        
        foreach ($paths as $dirs) {
            foreach ($l->filenames as $filename) {
                $searchedpath = $dirs . '/' . sprintf($filename, strtolower($className));
              if (file_exists($searchedpath)) {
                      @include_once $searchedpath;
                    return;
                }
            }
        }
        return;
    }

}

spl_autoload_register('Autoloader::loader'); 

