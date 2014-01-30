<?php
    // Orlov Micro Framework

    class Omf
    {
        private $request_uri = '/';
        private $routes = array();
        private $current_route = array();
        private $view_path = '';  // путь к папке с вьюхами
        private static $instance = null;

        private function __construct()
        {
            $this->routes = array();
            $this->set_view_path(dirname(dirname(__FILE__)).'/');
            $this->request_uri = isset($_SERVER['REQUEST_URI'])
                               ? $_SERVER['REQUEST_URI']
                               : '/';
        }

        public static function instance()
        {
            if (is_null(self::$instance)) self::$instance = new omf;
            return self::$instance;
        }

        public static function i() { return self::instance(); }

        public function route($route, $callback, $name=null, array $validators=array(), $template='~^{@regexp}$~')
        {
                self::route_regexp(
                    self::route_helper($route, $validators, $template),
                    $callback,
                    $name
                );
        }

        public function route_helper($route, array $validators=array(), $template='~^{@regexp}$~')
        {
            $route_regexp = str_replace(array('[',']'), array('(?:',')?'), $route);

            if ($validators)
            {
                krsort($validators);
                foreach ($validators as $var=>$regexp)
                {
                    $route_regexp = str_replace('@'.$var, '('.$regexp.')', $route_regexp);
                }
            }

            $this->check_route_helper_regexp($route_regexp);

            $route_regexp = str_replace('{@regexp}', $route_regexp, $template);

            return $route_regexp;
        }

        private function check_route_helper_regexp($route_regexp) // проверяет остались ли в регулярке переменные валидатора
        {
            if (strpos($route_regexp,'@')) {
                $vars = array();
                if (preg_match_all('~@([a-z0-9]*)~i',$route_regexp, $regs))
                {
                    for ($i=0; $i<count($regs[0]); $i++)
                    {
                        $vars[]='@'.(empty($regs[1][$i])?'{'.$i.'}':$regs[1][$i]);
                    }
                }
                throw new Exception('Not found validators for vars: '.implode(', ',$vars).' in route: '. $route_regexp);
            }
        }

        public function route_regexp($regexp, $callback, $name=null)
        {
                $this->routes[] = array(
                    'regexp'=>$regexp,
                    'callback'=>$callback,
                    'name'=>$name,
                );
        }

        public function route_regexp_array(array $regexps, $callback, $name=null)
        {
            foreach ($regexps as $regexp)
            {
                self::route_regexp($regexp, $callback, $name);
            }
        }

        public function start()
        {
            foreach($this->routes as $route)
            {
                if (preg_match($route['regexp'], $this->request_uri, $regs))
                {
                    $this->current_route = $route;
                    $this->current_route['request_uri'] = $this->request_uri;
                    $this->current_route['vars'] = $regs;
                    array_shift($regs);
                    call_user_func_array ($route['callback'], $regs);
                    break;
                }
            }
        }

        public function get_current_route() { return $this->current_route; }

        public function route_name_match($regexp)
        {
           $current_route = $this->get_current_route();
            return preg_match($regexp, $current_route['name']);
        }

        public function model($model) { return Omf_Model::i($model); }
        public function view($view) { return new Omf_View($view, $this->view_path); }
        public function controller(array $params=array()) { return new Omf_Controller($params); }

        public static function m($model) { return self::i()->model($model); }
        public static function v($view){return self::i()->view($view);}
        public static function c(array $params=array()){ return self::i()->controller($params); }


        public function set_view_path($path)
        {
            $this->view_path = $path;
        }

    }