<?php

    $c = $_GET['c'] ?? 'Login';
    $m = $_GET['m'] ?? 'index';

    require_once("controller/Controller.class.php");
    require_once("controller/$c.class.php");

    $controller = new $c;
    $controller->$m();


// $c = $_GET['c'] ?? 'Login';
// $m = $_GET['m'] ?? 'index';

// require_once("controller/Controller.class.php");
// require_once("controller/$c.class.php");

// $controller = new $c;
// $controller->$m();