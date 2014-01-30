<?php

    class Controller_Base_Template
    {
        protected $header;
        protected $body;
        protected $footer;

        public function __construct()
        {
            $this->header = omf::i()->view('base/header');
            $this->body = omf::i()->view('base/body');
            $this->footer = omf::i()->view('base/footer');

            $this->header->set(array('title'=>'','top_menu'=>false));
            $this->body->set(array('body'=>''));
        }

        public function render($return=FALSE)
        {
            $view = omf::i()->view('base/index');

            $view->set(array(
                'header' => $this->header->render(TRUE),
                'body' => $this->body->render(TRUE),
                'footer' => $this->footer->render(TRUE),
            ));

            $ret = $view->render(TRUE);

            if (!$return) echo $ret; else return $ret;
        }
    }
