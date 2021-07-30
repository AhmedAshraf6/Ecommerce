<?php

    // Error Reporting
    ini_set('display_errors','On');
    error_reporting(E_ALL);


    include "admins/connect.php";

    $sessionUser = '';
    if(isset($_SESSION['user'])){
        $sessionUser = $_SESSION['user'];
    }
    //Routes
    $tpl  = 'includes/templetes/';
    $lang = 'includes/languages/';
    $fun  = 'includes/functions/';

    // Include The Important Files
    include $fun . 'functions.php';
    include $lang . 'english.php';
    include $tpl . 'header.php';
    

    