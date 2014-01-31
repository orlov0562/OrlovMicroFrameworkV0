<?php

    spl_autoload_register(function ($class) {
        $class = str_replace('_', '/', $class);
        $class = strtolower($class);
        $class_filepath =  ROOT_DIR.'inc/classes/' . $class . '.php';
        include $class_filepath;
    });

    set_exception_handler(function($e){
        omf::c(array(
            'controller'=>'errors',
            'action'=>'custom',
            'vars'=>array(
                'Exception',
                $e->getMessage().'<hr><pre>'.$e->getTraceAsString().'</pre>'
            ),
        ));
    });

    require_once(ROOT_DIR.'inc/config.php');

    header('Content-Type: text/html; charset=UTF-8');