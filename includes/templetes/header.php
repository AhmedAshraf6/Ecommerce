<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php getTitle() ?></title>
        <link rel="stylesheet" href="layout/css/bootstrap.min.css">
        <link rel="stylesheet" href="layout/css/all.min.css">
        <link rel="stylesheet" href="layout/css/front.css">
        
    </head>
    <body>
    <div class="upper-bar">
        <div class="container">
            <?php
               if(isset($_SESSION['user'])){ ?>
            
                    <img class="my-image img-thumbnail img-circle" src="img.png" alt="" />
                    <div class="btn-group my-info">
                        <span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <?php echo $sessionUser ?>
                            <span class="caret"></span>
                        </span>
                        <ul class="dropdown-menu">
                            <li><a href="profile.php">My Profile</a></li>
                            <li><a href="newadd.php">New Item</a></li>
                            <li><a href="profile.php#my-addds">My Items</a></li>
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
                    </div>                     

              <?php } 
            else { ?>
            <a href="login.php">
                <span class="pull-right">Login/Sign</span>
            </a>
            <?php } ?>
            
            
        </div>
    </div>
    <nav class="navbar navbar-inverse">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#abb-nav" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Home Page</a>
        </div>
        <div class="collapse navbar-collapse" id="abb-nav">
          <ul class="nav navbar-nav navbar-right">
              
              <?php 
              
                foreach(getCat() as $cat){
                    
                    echo '<li><a href="categories.php?pageid='. $cat['ID'].'&pagename='.str_replace(' ','-',$cat['Name']).'">'. $cat['Name']  .'</a></li>';
                }
              
              ?>
            
          </ul>
         
        </div> 
      </div>
    </nav>
