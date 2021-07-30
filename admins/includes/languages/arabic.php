<?php 



    function lang($phrase){
        
        static $lan = array(
        
        'MESSAGE' => 'اهلا',
            
        'ADMIN'   => 'القائد'
            
        
        );
        return $lan[$phrase];
    }