<?php

require_once ('./_init.php');

if( $_SERVER['REQUEST_METHOD'] == 'POST' )
{

    unset($_SESSION['usuario']);

}

header('Location: ./login.php');

?>