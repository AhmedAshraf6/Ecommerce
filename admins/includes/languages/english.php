<?php 



    function lang($phrase){
        
        static $lan = array(
        
                // NavBar Links

                'HOME_ADMIN'    => 'Home',
                'CATEGORIES'    => 'Categories',
                'EDIT_PRFILE'   => 'Edit Profile',
                'SETTINGS'      => 'Settings',
                'LOGOUT'        => 'Logout',
                'ITEMS'         => 'Items',
                'Statstics'       => 'Members',      
                'COMMENTS'       => 'Comments',      
                'SATISTICS'     => 'Logout',
                'LOGS'          => 'Logs'
        
        );
        return $lan[$phrase];
    }