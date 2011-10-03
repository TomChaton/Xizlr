<?php
/*
* @author Ken Lalobo
*
*/
require_once('../Private/Bootstrap.php');

$objRouter = new \Xizlr\System\Router;
$objRouter->Route($_SERVER["SCRIPT_URL"]);

exit;
