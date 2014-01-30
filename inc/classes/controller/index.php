<?php

    class Controller_Index  extends Controller_Base_Template
    {
        public function Action_Index($id=0)
        {
            $this->body->set(array(
                'body' => __CLASS__.'::'.__METHOD__,
            ));

            $this->header->set(array(
                'title' => 'Главная страница',
                'top_menu' => omf::i()->view('base/top_menu')->set(array(
                    'menu'=>omf::i()->model('Site')->get_top_menu(),
                ))->render(TRUE),

            ));

            $this->render();
        }
    }
