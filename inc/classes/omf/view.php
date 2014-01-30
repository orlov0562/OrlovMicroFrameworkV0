<?php

    class Omf_View
    {
        private $vars = array();
        private $view_filepath;

        public function __construct($view, $base_path='')
        {
            $view_filepath = $base_path
                             .'view/'
                             .strtolower(trim($view))
                             .'.php';

            if (!file_exists($view_filepath))
            {
                throw new Exception('View '.$view.' not found');
            }

            $this->view_filepath = $view_filepath;
        }

        public function set($vars, $val=null)
        {
            if (!is_array($vars)) $vars = array($vars=>$val);

            foreach ($vars as $var=>$val)
            {
                $this->vars[$var] = $val;
            }

            return $this;
        }

        public function add($vars, $val=null)
        {
            if (!is_array($vars)) $vars = array($vars=>$val);

            foreach ($vars as $var=>$val)
            {
                if (!isset($this->vars[$var])) $this->vars[$var] = '';
                $this->vars[$var] .= $val;
            }

            return $this;
        }

        public function render($return=FALSE)
        {
            $old_err_reporting_level = error_reporting();
            error_reporting($old_err_reporting_level & ~E_NOTICE);
            ob_start();
            extract($this->vars);
            include $this->view_filepath;
            $ret = ob_get_clean();
            error_reporting($old_err_reporting_level);
            if (!$return) echo $ret; else return $ret;
        }


    }