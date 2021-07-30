<?php

   session_start();
   if(isset ($_SESSION['Username'])){
       
    $pageTitle = 'Dashboard';
    include "init.php";
     
    /* Start Dashboard */
       
    // getLatest function
    $numUser = 5; // Number Of Latest Users
    $numItem = 5; // Number Of Latest Items
    $numComments = 2; // Number Of Latest Comments
    $latestUsers = getLatest('*','users','UserID',$numUser);
    $latestItems = getLatest('*','items','Item_ID',$numItem);

       

    ?>     
    <div class="container home-stats text-center">
        <h1>Dashboard</h1>
        <div class="row">
            <div class="col-md-3">
                <div class="stat st-members">
                    <i class="fas fa-users"></i>
                    <div class="info">
                            Total Members 
                            <span><a href='members.php'><?php echo countItems('UserID','users') ?></a></span>
                    </div>
                </div>

            </div>
            <div class="col-md-3">
                <div class="stat st-pending">
                    <i class="fas fa-user-plus"></i>
                    <div class="info">
                        Pending Members
                        <span><a href='members.php?do=Manage&Page=Pending'>
                            <?php echo checkItem('RegStatus','users',0) ?>
                        </a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-items">
                    <i class="fas fa-tag"></i>
                    <div class='info'>                
                        Total Items
                        <span><a href='categories.php'><?php echo countItems('Item_ID','items') ?></a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-comments">
                    <i class='fas fa-comments'></i>
                    <div class='info'>
                        Total Comments
                        <span><a href='comments.php'><?php echo countItems('c_id','comments') ?></a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>   
   
    <div class="container latest">
        
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class='panel-heading'>
                        <i class="fas fa-users">
                        </i>Latest Registered <?php echo $numUser ?> Users
                        <span class="toggle-info pull-right">
                            <i class="fa fa-plus fa-lg"></i>
                        </span>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled latest-users">
                            <?php
                                if(!empty($latestUsers)){
                                    
                                  foreach($latestUsers as $user){
                                    
                                    echo '<li>';
                                        echo $user['Username'];
                                        echo    "<a href='members.php?do=Edit&userid=". $user['UserID'] ."'>";
                                            echo    '<span class="btn btn-success pull-right">';
                                                echo   "<i class='fas fa-edit'></i>Edit";

                                                if(!$user['RegStatus']){

                                                    echo "<a href='members.php?do=Activate&userid=".$user['UserID']."' class='btn btn-info pull-right activate'><i class='fas fa-window-close'></i>Activate</a>";
                                                }
                                            echo   '</span>';
                                        echo  "</a>";
                                    echo  '</li>';

                                  }
                                }else{
                                    echo 'There\'s No User To Show';
                                }
                              
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            
             <div class="row">
                    <div class="col-sm-6">
                        <div class="panel panel-default">
                            <div class='panel-heading'>
                                <i class="fas fa-users">
                                </i>Latest Items <?php echo $numUser ?> Items
                                <span class="toggle-info pull-right">
                                    <i class="fa fa-plus fa-lg"></i>
                                </span>
                            </div>
                        <div class="panel-body">
                                <ul class="list-unstyled latest-users">
                                    <?php
                                        if(!empty($latestItems)){
                                            foreach($latestItems as $item){

                                            echo '<li>';
                                                echo $item['Name'];
                                                echo    "<a href='items.php?do=Edit&itemid=". $item['Item_ID'] ."'>";
                                                    echo    '<span class="btn btn-success pull-right">';
                                                        echo   "<i class='fas fa-edit'></i>Edit";

                                                        if(!$item['Approve']){

                                                            echo "<a href='items.php?do=Approve&itemid=".$item['Item_ID']."' class='btn btn-info pull-right activate'><i class='fas fa-check'></i>Approve</a>";
                                                        }
                                                    echo   '</span>';
                                                echo  "</a>";
                                            echo  '</li>';

                                            }
                                        }else{
                                            echo 'There\'s No Item To Show';
                                        }
                                    ?>
                                </ul>
                            </div>
                       </div>
                </div>
                 
                <!-- Start Latest Comments -->
                 
				<div class="row">
					<div class="col-sm-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="fa fa-comments-o"></i> 
								Latest <?php echo $numComments ?> Comments 
								<span class="toggle-info pull-right">
									<i class="fa fa-plus fa-lg"></i>
								</span>
							</div>
							<div class="panel-body">
								<?php
									$stmt = $con->prepare("SELECT 
																comments.*, users.Username AS Member  
															FROM 
																comments
															INNER JOIN 
																users 
															ON 
																users.UserID = comments.user_id
															ORDER BY 
																c_id DESC
															LIMIT $numComments");

									$stmt->execute();
									$comments = $stmt->fetchAll();

									if (! empty($comments)) {
										foreach ($comments as $comment) {
											echo '<div class="comment-box">';
												echo '<span class="member-n">
													<a href="members.php?do=Edit&userid=' . $comment['user_id'] . '">
														' . $comment['Member'] . '</a></span>';
												echo '<p class="member-c">' . $comment['comment'] . '</p>';
											echo '</div>';
										}
									} else {
										echo 'There\'s No Comments To Show';
									}
								?>
							</div>
						</div>
					</div>
				</div>
				<!-- End Latest Comments -->
             </div>
            
    
    <?php
    /* End Dashboard */  
       
    include $tpl . "footer.php";
   }else{
       header('Location : index.php');
       exit();
   }