<?php

    class Controller_News extends Controller_Base_Template
    {
        private $view;

        public function before() // есть before, after
        {
            $this->view = omf::v('page');  // альтернативный вызов view
        }

        public function Action_Index($id='', $page=0)
        {
            $this->view->set(array(
                'header' => omf::i()->model('News')->get_header(), // вызов модели
                'content' => omf::m('News')->get_content(), // альтернативный вызов модели
            ));

            $this->view->add(array(
                'content' => '<hr><pre>'.print_r(omf::i()->get_current_route(),TRUE).'</pre>'
            ))->add('content', '<hr>ID: '.$id.'; page:'.$page);
        }

        public function Action_Date($date)
        {
            $this->view->set(array(
                'header' => omf::i()->model('News')->get_header().' с датой',
                'content' => omf::i()->model('News')->get_content()
                            .'<hr><pre>'.print_r(omf::i()->get_current_route(),TRUE).'</pre>'
                            .'<hr>Date: '.$date
                ,
            ));
        }

        public function after()
        {
            $this->body->set('body', $this->view->render(TRUE));

            $this->header->set(array(
                'title' => 'News page',
                'top_menu' => omf::v('base/top_menu')->set(array(               // можем делать цепочку вызовов view
                    'menu'=>omf::m('Site')->get_top_menu(),
                ))->render(TRUE),
            ));

            $this->render();
        }


    }