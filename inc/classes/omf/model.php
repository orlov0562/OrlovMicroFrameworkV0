<?php

    class Omf_Model
    {
        private static $instances = array();
        
        private function __construct()
        {
        }

        public static function instance($model)
        {
            $model = 'Model_'.self::prepare_name($model);
            if (!class_exists($model, TRUE)) throw new Exception('Class '.$model.' not found');
            if (!isset(self::$instances[$model])) self::$instances[$model] = new $model;
            return self::$instances[$model];
        }

        public static function i($model)
        {
            return self::instance($model);
        }

        private static function prepare_name($name)
        {
            $name = strtolower(trim($name));
            $name = preg_replace_callback('/\b\p{Ll}/', function($match){
                return mb_strtoupper($match[0]);
            }, $name);
            return $name;
        }
    }