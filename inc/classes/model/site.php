<?php

    class Model_Site
    {
        public function get_top_menu()
        {

           $menu = array(
              array(
                  'name'=>'Home',
                  'url'=>'/',
                  'current'=>omf::i()->route_name_match('~^index$~i'),       // проверяем подходит ли текущее имя роута
              ),
              array(
                  'name'=>'News',
                  'url'=>'/news',
                  'current'=>omf::i()->route_name_match('~^news~i'),
              ),
           );
           return $menu;
        }

    }