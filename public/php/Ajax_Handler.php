<?php
require_once '../../vendor/autoload.php';
require '../../src/config/jenkins.php';
require '../../src/core/Controller.php';
require '../../src/controllers/' . $_POST["class"] . '.php';
$controller = new $_POST["class"];
if(!$_POST["params"]) {
    $_POST["params"] = [];
}
// Include the class you want to call a method from
call_user_func_array([$controller, $_POST["method"]], $_POST["params"]);