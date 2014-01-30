<?php

    spl_autoload_register(function ($class) {
        $class = str_replace('_', '/', $class);
        $class = strtolower($class);
        $class_filepath =  ROOT_DIR.'inc/classes/' . $class . '.php';
        include $class_filepath;
    });

    set_exception_handler(function($e){
        $view = new Controller_Errors;
        $view->before();
        $view->Action_Custom(
            'Exception',
            $e->getMessage().'<hr>'.'<pre>'.$e->getTraceAsString().'</pre>'
        );
        $view->after();
    });

    require_once(ROOT_DIR.'inc/config.php');

    header('Content-Type: text/html; charset=UTF-8');