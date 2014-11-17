<?php

/**
 * Description - index page
 *
 * @author -- wildernix
 */

require 'it_db_controller.php';

$DataBase = new it_db_controller();
$DataBase->connect();
$DataBase->select();


?>
