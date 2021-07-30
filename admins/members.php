<?php 

  /*
  
  -- Manage Member Page
  -- You Can Add | Delete | Edit Member From Here
  
  */


   session_start();

   $pageTitle = 'Members';

   if(isset ($_SESSION['Username'])){
       
    include "init.php";
       
    if(isset($_GET['do'])){
       
       $do = $_GET['do'];
    }else{
       $do = 'Manage';
    }
   
    // Start Manage Page
       
    if($do=='Manage'){ // Manage members Page
        
        $query = '';
        if(isset($_GET['Page']) && $_GET['Page']=='Pending' ){
            
            $query = 'AND RegStatus=0 ';
        }
   

        // Select All Users Except Admin

        $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query");

        // Execute The Statement
        $stmt->execute();

        // Assign To Variable
        $rows = $stmt->fetchAll();
        
        if(!empty($rows)){

     ?>
       
        <h1 class="text-center">Add New Member</h1>

        <div class="container">
            <div class="table-responsive">
                <table class="main-table table text-center table-bordered">
                    <tr>
                        <td>#ID</td>
                        <td>Username</td>
                        <td>Email</td>
                        <td>Full Name</td>
                        <td>Registered Date</td>
                        <td>Control</td>
                    </tr>
                    <?php 
                    
                    foreach($rows as $row){
                        
                        echo "<tr>";
                           echo "<td>". $row['UserID'] . "</td>";
                           echo "<td>". $row['Username'] . "</td>";
                           echo "<td>". $row['Email'] . "</td>";
                           echo "<td>". $row['Fullname'] . "</td>";
                           echo "<td></td>";
                           echo "<td>
                              
                                <a href='members.php?do=Edit&userid=".$row['UserID']."' class='btn btn-success'><i class='fas fa-edit'></i>Edit</a>
                                <a href='members.php?do=Delete&userid=".$row['UserID']."' class='btn btn-danger cm'><i class='fas fa-window-close'></i>Delete </a>";
                        
                                if(!$row['RegStatus']){
                                    
                                    echo "<a href='members.php?do=Activate&userid=".$row['UserID']."' class='btn btn-info activate'><i class='fas fa-check'></i>Activate</a>";
                                }
                                
            
                             echo "</td>";

                        echo "</tr>";
                    }
                    
                    ?>
                    
                </table>
            </div>
            <a href="members.php?do=Add" class="btn btn-primary"><i class="fas fa-plus"></i> New Member</a>
        </div>
        
        <?php }else{
            
                echo '<div class="container">';
					echo '<div class="nice-message">There\'s No Member To Show</div>';
					echo '<a href="members.php?do=Add" class="btn btn-primary">
							<i class="fa fa-plus"></i> New Member
						</a>';
				echo '</div>';
        }
       }elseif($do=='Add'){// Add Members Page ?>
        
             <h1 class="text-center">Add New Member</h1>

             <div class="container">
                 <form class="form-horizontel" action="?do=Insert" method="post" enctype="multipart/form-data">
                     <!-- Start Username Field -->
                      <div class="row">
                     <div class="form-group form-group-lg">
                         <label class="col-sm-2 control-label">
                         Username</label>
                         <div class="col-sm-10 col-md-4">
                             <input type='text' name="username" class="form-control" autocomplete='off' required='required'/>
                         </div>
                     </div>
                        </div>
                     <!-- End Username Field -->

                     <!-- Start Password Field -->
                     <div class="row">
                     <div class="form-group form-group-lg">
                         <label class="col-sm-2 control-label">
                         Password</label>
                         <div class="col-sm-10 col-md-4">
                             <input type='password' name="password" class="form-control special-pass" autocomplete='new-password' required='required'/>
                             <i onmouseover="showPassword()" onmouseout='hidePassword()' class="show-pass fas fa-eye fa-2x" ></i>
                         </div>
                     </div>
                    </div>
                     <!-- End Password Field -->

                     <!-- Start Email Field -->
                     <div class="row">
                     <div class="form-group form-group-lg">
                         <label class="col-sm-2  control-label">
                         Email</label>
                         <div class="col-sm-10 col-md-4">
                             <input type='email' name="email" class="form-control" required='required'/>
                         </div>
                     </div>
                    </div>
                     <!-- End Email Field -->

                     <!-- Start Fullname Field -->
                     <div class="row">
                     <div class="form-group form-group-lg">
                         <label class="col-sm-2 control-label">
                         Fullname</label>
                         <div class="col-sm-10 col-md-4">
                             <input type='text' name="fullname" class="form-control" required='required' />
                         </div>
                     </div>
                    </div>
                     <!-- End Fullname Field -->         
                     
                     <!-- Start Image Upload -->
                     <div class="row">
                     <div class="form-group form-group-lg">
                         <label class="col-sm-2 control-label">
                         Upload Image</label>
                         <div class="col-sm-10 col-md-4">
                             <input type='file' name="avatar" class="form-control" required='required' />
                         </div>
                     </div>
                    </div>
                     <!-- End Image Upload -->

                     <!-- Start Submit Field -->

                     <div class="form-group form-group-lg">
                         <div class="col-sm-offset-2 col-sm-10">
                             <input type='submit' value="Add Member" class="btn btn-primary btn-lg" />
                         </div>
                     </div>

                     <!-- End Submit Field -->

                 </form>
             </div>
  
        
            <?php 
                      
    }elseif($do=='Insert'){ // Insert Member Page
        
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            

            // Upload Variables

            $avatarName = $_FILES['avatar']['name'];
            $avatarSize = $_FILES['avatar']['size'];
            $avatarTmp	= $_FILES['avatar']['tmp_name'];
            $avatarType = $_FILES['avatar']['type'];

            // List Of Allowed File Typed To Upload

            $avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");

            // Get Avatar Extension

            $avatarExtension = strtolower(end(explode('.', $avatarName)));

            
            // Get Variables From The Form
            
            echo '<h1 class="text-center">Update Member</h1>';  
            echo "<div class='container'>";
            
            $username   = $_POST['username'];
            $pass       = $_POST['password'];
            $email      = $_POST['email'];
            $name       = $_POST['fullname'];
            
            $hashpass = sha1($_POST['password']);
            // Validate form 
            
            $formErrors = array();
            
            if(empty($username)){
                
                $formErrors[] = 'Username Can\'t Be <strong>Empty</strong>'; 
                
            }
            if(strlen($username) < 4 && strlen($username)!=''){
                
                $formErrors[] = 'Username Can\'t Be Less Than <strong>4 Charchters</strong>'; 
            }
            if(empty($pass)){
                
                $formErrors[] = 'Password Can\'t Be <strong>Empty</strong>'; 
                
            }
            if(empty($email)){
                
                $formErrors[] = 'Email Can\'t Be <strong>Empty</strong>'; 
                
            }
            if(empty($name)){
                
                $formErrors[] = 'Fullname Can\'t Be <strong>Empty</strong>'; 
                
            }
            foreach($formErrors as $error){
                
                echo "<div class='alert alert-danger'>" .$error . '</div>';
            }
            

            if (! empty($avatarName) && ! in_array($avatarExtension, $avatarAllowedExtension)) {
                $formErrors[] = 'This Extension Is Not <strong>Allowed</strong>';
            }

            if (empty($avatarName)) {
                $formErrors[] = 'Avatar Is <strong>Required</strong>';
            }

            if ($avatarSize > 4194304) {
                $formErrors[] = 'Avatar Cant Be Larger Than <strong>4MB</strong>';
            }
           // Check If There's No Error In Operation
            
           if(empty($formErrors)){
               
                $avatar = rand(0, 10000000000) . '_' . $avatarName;

                move_uploaded_file($avatarTmp, "uploads\avatars\\" . $avatar);
               
               // Check If User Exist In Database
               $check = checkItem('Username','users',$username); 
               
               if(!$check){

                    // Insert Userinfo In Database

                    $stmt = $con-> prepare("INSERT INTO users(Username,Password,Email,Fullname,RegStatus,Avatar) VALUES(:zuser,:zpass,:zmail,:zname,1,:zava)");
                    $stmt->execute(array(

                    'zuser' => $username,
                    'zpass' => $hashpass,
                    'zmail' => $email,
                    'zname' => $name,
                    'zava' => $avatar

                    ));
                    // Echo Success Message
                   
                $msg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';
                 redirectHome($msg,'back');




               }else{
                   
                   $msg = '<div class="alert alert-danger">Sorry This User Already Exist</div>';
                   redirectHome($msg,'back');
               }
            
           }

            
        }else{
            
             echo '<div class="container">';
             $msg =  '<div class="alert alert-danger">you can\'t Browse this page directly</div>';
             redirectHome($msg);
             echo '</div>';
        }
         
       echo "</div>";       
    }
    elseif($do=='Edit'){
        
        // Check If Get Request Is Numeric And Get Integer Value
        
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        
        // Select All Data Depend On This Id
        
        $stmt = $con->prepare("SELECT * FROM users WHERE UserID=? LIMIT 1");
        $stmt->execute(array($userid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        
        if($stmt->rowCount() > 0){?>
       
             <h1 class="text-center">Edit Member</h1>

             <div class="container">
                 <form class="form-horizontel" action="?do=Update" method="post">
                     <input type='hidden' name="userid" value="<?php echo $userid ?>">
                     <!-- Start Username Field -->
                      <div class="row">
                     <div class="form-group form-group-lg">
                         <label class="col-sm-2 control-label">
                         Username</label>
                         <div class="col-sm-10 col-md-4">
                             <input type='text' name="username" class="form-control" value ="<?php echo $row['Username']?>"autocomplete='off' required='required'/>
                         </div>
                     </div>
                        </div>
                     <!-- End Username Field -->

                     <!-- Start Password Field -->
                     <div class="row">
                     <div class="form-group form-group-lg">
                         <label class="col-sm-2 control-label">
                         Password</label>
                         <div class="col-sm-10 col-md-4">
                             <input type='hidden' name="oldpassword" value="<?php echo $row['Password']?>" />
                             <input type='password' name="newpassword" class="form-control" autocomplete='new-password'/>
                         </div>
                     </div>
                    </div>
                     <!-- End Password Field -->

                     <!-- Start Email Field -->
                     <div class="row">
                     <div class="form-group form-group-lg">
                         <label class="col-sm-2  control-label">
                         Email</label>
                         <div class="col-sm-10 col-md-4">
                             <input type='email' name="email" class="form-control" value ="<?php echo $row['Email']?>" required='required'/>
                         </div>
                     </div>
                    </div>
                     <!-- End Email Field -->

                     <!-- Start Fullname Field -->
                     <div class="row">
                     <div class="form-group form-group-lg">
                         <label class="col-sm-2 control-label">
                         Fullname</label>
                         <div class="col-sm-10 col-md-4">
                             <input type='text' name="fullname" class="form-control" value ="<?php echo $row['Fullname']?>" required='required' />
                         </div>
                     </div>
                    </div>
                     <!-- End Fullname Field -->

                     <!-- Start Submit Field -->

                     <div class="form-group form-group-lg">
                         <div class="col-sm-offset-2 col-sm-10">
                             <input type='submit' value="Save" class="btn btn-primary btn-lg" />
                         </div>
                     </div>

                     <!-- End Submit Field -->

                 </form>
             </div>
  
    <?php
                                  
          }else{
            
            echo '<div class="container">';
            
            $msg =  '<div class="alert alert-danger">There\'s No Such ID</div>';
            redirectHome($msg);
            
            echo '</div>';
        }
    } elseif($do=='Update'){ // Update Page
        
        echo '<h1 class="text-center">Update Member</h1>';  
        echo "<div class='container'>";
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            // Get Variables From The Form
            
            $id         = $_POST['userid'];
            $username   = $_POST['username'];
            $email      = $_POST['email'];
            $name   = $_POST['fullname'];
            
            // Password Trick
            
            $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']) ;
          
            // Validate form 
            
            $formErrors = array();
            
            if(empty($username)){
                
                $formErrors[] = 'Username Can\'t Be <strong>Empty</strong>'; 
                
            }
            if(strlen($username) < 4 && strlen($username)!=''){
                
                $formErrors[] = 'Username Can\'t Be Less Than <strong>4 Charchters</strong>'; 
            }
            if(empty($email)){
                
                $formErrors[] = 'Email Can\'t Be <strong>Empty</strong>'; 
                
            }
            if(empty($name)){
                
                $formErrors[] = 'Fullname Can\'t Be <strong>Empty</strong>'; 
                
            }
            foreach($formErrors as $error){
                
                echo "<div class='alert alert-danger'>" .$error . '</div>';
            }
            
           // Check If There's No Error In Operation
            
           if(empty($formErrors)){
               
					$stmt2 = $con->prepare("SELECT 
												*
											FROM 
												users
											WHERE
												Username = ?
											AND 
												UserID != ?");

					$stmt2->execute(array($user, $id));

					$count = $stmt2->rowCount();

					if ($count == 1) {

						$theMsg = '<div class="alert alert-danger">Sorry This User Is Exist</div>';

						redirectHome($theMsg, 'back');

					} else { 

						// Update The Database With This Info

						$stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ?, Password = ? WHERE UserID = ?");

						$stmt->execute(array($user, $email, $name, $pass, $id));

						// Echo Success Message

						$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

						redirectHome($theMsg, 'back');

					}

				}

			} else {

				$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

				redirectHome($theMsg);

			}

			echo "</div>";
    }elseif($do=='Delete'){   // Delete Member From Database

        echo '<h1 class="text-center">Update Member</h1>';  
        echo "<div class='container'>";
        
            // Check If Get Request Is Numeric And Get Integer Value

            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

            // Select All Data Depend On This Id
            $check = checkItem('UserID','users',$userid);

            if($check > 0){

                $stmt = $con->prepare('DELETE FROM users WHERE UserID=:zuser');
                $stmt->bindParam(':zuser',$userid);
                $stmt->execute();
                $msg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';  
                redirectHome($msg,'back');



            }else{
                $msg = '<div class="alert alert-danger"> This Id Isn\'t Exist</div>';
                redirectHome($msg);

            }

       echo "</div>";
    } elseif($do == 'Activate'){ // Activate Member From Database
    
        echo '<h1 class="text-center">Activate Member</h1>';  
        echo "<div class='container'>";
        
            // Check If Get Request Is Numeric And Get Integer Value

            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

            // Select All Data Depend On This Id
            $check = checkItem('UserID','users',$userid);

            if($check > 0){

                $stmt = $con->prepare('UPDATE users SET RegStatus = 1 WHERE UserID = ?');
                $stmt->execute(array($userid));
                $msg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Activited</div>';  
                redirectHome($msg,'back');



            }else{
                $msg = '<div class="alert alert-danger"> This Id Isn\'t Exist</div>';
                redirectHome($msg);

            }

       echo "</div>";
        
    }

    include $tpl . "footer.php";
       
   } // if there is session in username
   else{
       
       header('Location : index.php');
       exit();
       
    }
