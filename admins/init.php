<?php


    include "connect.php";

    //Routes
    $tpl  = 'includes/templetes/';
    $lang = 'includes/languages/';
    $fun  = 'includes/functions/';

    // Include The Important Files
    include $fun . 'functions.php';
    include $lang . 'english.php';
    include $tpl . 'header.php';

   // Include The Navbar Off All Pages Except one With No $noNavbar 

   if(!isset($noNavbar)){
       
         include $tpl . 'navbar.php';

   }
    

    