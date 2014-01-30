<?php
    define('ROOT_DIR', dirname(__FILE__).'/');

    require_once(ROOT_DIR.'inc/init.php');
    require_once(ROOT_DIR.'inc/routes.php');


    omf::i()->start();