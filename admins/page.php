<?php

   /*
    
    Categories => [Manage | Edit | Insert | Delete | Add | update | stats]
    
   */

   $do = '';

   if(isset($_GET['do'])){
       
       $do = $_GET['do'];
   }else{
       $do = 'Manage';
   }

   if($do=='Manage'){
       
       echo 'Welcome You Are In Manage Category Page';
       
   }elseif($do=='Add'){
       
       echo 'Welcome You Are In Add Category Page';
       
   }elseif($do=='Insert'){
       
       echo 'Welcome You Are In Insert Category Page';
       
   }else{
       
       echo 'Error there\'s No Page With This Name';
       
   }
