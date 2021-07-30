    <?php 

        session_start();
        $pageTitle = 'my profile';
        include "init.php";
        if(isset($_SESSION['user'])){

        $getUser = $con->prepare("SELECT * FROM users WHERE Username=?");
        $getUser->execute(array($sessionUser));
        $getInfo = $getUser->fetch();
    ?>

    <h1 class="text-center">My Profile</h1> 

    <div class="information block">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    My Information
                </div>
                <div class="panel-body">
                    <ul class="list-unstyled">
					<li>
						<i class="fas fa-unlock-alt fa-fw"></i>
						<span>Login Name</span> : <?php echo $getInfo['Username'] ?>
					</li>
					<li>
						<i class="fas fa-envelope-square fa-fw"></i>
						<span>Email</span> : <?php echo $getInfo['Email'] ?>
					</li>
					<li>
						<i class="fa fa-user fa-fw"></i>
						<span>Full Name</span> : <?php echo $getInfo['Fullname'] ?>
					</li>
					<li>
						<i class="fa fa-tags fa-fw"></i>
						<span>Fav Category</span> :
					</li>
				</ul>
				<a href="#" class="btn btn-default">Edit Information</a>
                </div>
            </div>
        </div>
    </div>


    <div id='my-addds' class="my-adds block">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Latest Adds
                </div>
                <div class="panel-body">
                        <?php
                          if(!empty(getItemUser($getInfo['UserID']))){
                              echo "<div class='row'>";
                                  foreach(getItemUser($getInfo['UserID'])as $item){
                                          echo '<div class="col-sm-6 col-md-3">';
                                                echo '<div class="thumbnail item-box">';
                                                    if($item['Approve']==0){
                                                        echo '<span class="approve-status">Waiting Approval</span>';
                                                    }
                                                    echo '<span class="price-tag">$' . $item['Price'] . '</span>';
                                                    echo '<img class="img-responsive" src="img.png" alt="" />';
                                                    echo '<div class="caption">';
                                                        echo '<h3><a href="items.php?itemid='. $item['Item_ID'] .'">' . $item['Name'] .'</a></h3>';
                                                        echo '<p>' . $item['Description'] . '</p>';
                                                        echo '<div class="date">' . $item['Add_Date'] . '</div>';
                                                    echo '</div>';
                                                echo '</div>';
                                            echo '</div>';
                                  }
                              echo "</div>";
                          }else{
                              echo 'ther\'s no ads to show <a href="newadd.php">New Add</a> ';
                                  
                          }
                        ?>
                </div>
            </div>
        </div>
    </div>

    <div class="my-comments block">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Latest Comments
                </div>
                <div class="panel-body">
                    <?php

                      $stmt = $con->prepare("SELECT comment FROM comments WHERE user_id = ?");
                      $stmt->execute(array($getInfo['UserID']));
                      $comments= $stmt->fetchAll(); 

                      if(!empty($comments)){
                          foreach($comments as $comment){

                              echo '<p>' .$comment['comment'] . '</p>';
                          }
                      }else{

                          echo 'There\'s No Comments To Show';
                      }
                    ?>
                </div>
            </div>
        </div>
    </div>




    <?php

    }
    else{

    header('Location:login.php');
    exit();
    }
    include $tpl . "footer.php";?>






