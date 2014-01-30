<?php

    class Model_News
    {
        public function get_header()
        {
           return 'Новости';
        }

        public function get_content()
        {
           return '
                Контент на странице<br><br>

                Проверка подсветки пункта меню при изменении роутов:
                <ul>
                    <li><a href="/news">Роут 1, Url 1</a></li>
                    <li><a href="/news/">Роут 1, Url 2</a></li>
                    <li><a href="/news/index">Роут 1, Url 3</a><br><br></li>

                    <li><a href="/news/2">Роут 2, Url 1</a></li>
                    <li><a href="/news/test">Роут 2, Url 2</a></li>
                    <li><a href="/news/test/page-2">Роут 2, Url 3</a></li>
                    <li><a href="/news/test-2">Роут 2, Url 4</a><br><br></li>

                    <li><a href="/news/2013-04-01">Роут 3, Url 1</a><br><br></li>
                </ul>
           ';
        }
    }