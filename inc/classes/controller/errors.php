<?php

    class Controller_Errors extends Controller_Base_Template
    {
        private $view;

        public function before() // есть before, after
        {
            $this->view = omf::v('page');  // альтернативный вызов view
        }

        public function Action_404()
        {
            $this->header->set('title','Ошибка 404');
            $this->view->set(array(
                'header' => 'Ошибка 404',
                'content' => 'Страница не найдена',
            ));

        }

        public function Action_Custom($title, $content)
        {
            $this->header->set('title', 'Ошибка');
            $this->view->set(array(
                'header' => $title,
                'content' => $content,
            ));

        }

        public function after()
        {
            $this->body->set('body', $this->view->render(TRUE));
            $this->render();
        }
    }

