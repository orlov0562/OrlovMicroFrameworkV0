<?php

    class Omf_Controller
    {
        public function __construct(array $params=array())
        {
            $controller = isset($params['controller'])
                        ? $params['controller']
                        : 'Index';

            $action = isset($params['action'])
                        ? $params['action']
                        : 'Index';

            $vars = (isset($params['vars']) AND is_array($params['vars']))
                        ? $params['vars']
                        : array();

            $controller = 'Controller_'.$this->prepare_name($controller);
            $action = 'Action_'.$this->prepare_name($action);

            if (class_exists($controller, TRUE))
            {
                $obj = new $controller;
                $this->call_class_method($obj, 'before');
                $this->call_class_method($obj, $action, $vars, TRUE);
                $this->call_class_method($obj, 'after');
            }
            else
            {
                throw new Exception('Class '.$controller.' not found');
            }

        }

        private function prepare_name($name)
        {
            $name = strtolower(trim($name));
            $name = preg_replace_callback('/\b\p{Ll}/', function($match){
                return mb_strtoupper($match[0]);
            }, $name);
            return $name;
        }


        private function call_class_method($obj, $method, $vars=array(), $required_method=FALSE)
        {
            if (method_exists($obj, $method))
            {
                if (is_callable(array($obj, $method)))
                {
                    call_user_func_array(array($obj, $method), $vars);
                }
                else
                {
                    throw new Exception('Method '.get_class($obj).'::'.$method.' not callable');
                }
            }
            elseif($required_method)
            {
                throw new Exception('Method '.get_class($obj).'::'.$method.' not found');
            }
        }
    }