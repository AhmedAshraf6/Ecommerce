<?php

	/*
	================================================
	== Items Page
	================================================
	*/

	session_start();

	$pageTitle = 'Items';

	if (isset($_SESSION['Username'])) {

		include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		if ($do == 'Manage') { 
            
                $query = '';
                if(isset($_GET['Page']) && $_GET['Page']=='Pending' ){

                    $query = 'AND Approve=0 ';
                }
   
                $stmt = $con->prepare(" SELECT
                                               items.*, categories.name as Category_Name, users.Username
                                        FROM 
                                               items, categories, users 
                                        WHERE 
                                               items.Cat_ID = categories.ID 
                                        AND 
                                               items.Member_ID = UserID");

                // Execute The Statement
                $stmt->execute();

                // Assign To Variable
                $items = $stmt->fetchAll();
                
                if(!empty($items)){

                ?>

                <h1 class="text-center">Manage Items</h1>

                <div class="container">
                    <div class="table-responsive">
                        <table class="main-table table text-center table-bordered">
                            <tr>
                                <td>#ID</td>
                                <td>Name</td>
                                <td>Description</td>
                                <td>Adding Date</td>
                                <td>Registered Date</td>
                                <td>Category</td>
                                <td>Username</td>
                                <td>Control</td>
                            </tr>
                            <?php 

                            foreach($items as $item){

                                echo "<tr>";
                                   echo "<td>". $item['Item_ID'] . "</td>";
                                   echo "<td>". $item['Name'] . "</td>";
                                   echo "<td>". $item['Description'] . "</td>";
                                   echo "<td>". $item['Price'] . "</td>";
                                   echo "<td>". $item['Add_Date'] . "</td>";
                                   echo "<td>". $item['Category_Name'] . "</td>";
                                   echo "<td>". $item['Username'] . "</td>";
                                   echo "<td>
                                   
                                        <a href='items.php?do=Edit&itemid=".$item['Item_ID']."' class='btn btn-success'><i class='fas fa-edit'></i>Edit</a>
                                        <a href='items.php?do=Delete&itemid=".$item['Item_ID']."' class='btn btn-danger cm'><i class='fas fa-window-close'></i>Delete </a>";
                                        if(!$item['Approve']){

                                            echo "<a href='items.php?do=Approve&itemid=".$item['Item_ID']."' class='btn btn-info activate'><i class='fas fa-check'></i>Approve</a>";
                                        }

                                  echo "</td>";

                                echo "</tr>";
                            }

                            ?>

                        </table>
                    </div>
                    <a href="items.php?do=Add" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> New Item</a>
                </div>
            <?php }else{
                    
                echo '<div class="container">';
					echo '<div class="nice-message">There\'s No Item To Show</div>';
					echo '<a href="items.php?do=Add" class="btn btn-primary">
							<i class="fa fa-plus"></i> New Item
						  </a>';
				echo '</div>';
                    
                }
            
	     } elseif ($do == 'Add') { ?>
            
            <h1 class="text-center">Add New Item</h1>

             <div class="container">
                 <form class="form-horizontel" action="?do=Insert" method="post">

                     <!-- Start Name Field -->
                     
                     <div class="row">
                         <div class="form-group form-group-lg">
                             <label class="col-sm-2 control-label">
                             Name</label>
                             <div class="col-sm-10 col-md-4">
                                 <input type='text'
                                        name="name" 
                                        class="form-control" 
                                        placeholder="Name Of The Item"/>
                             </div>
                         </div>
                     </div>
                     
                     <!-- End Name Field -->
                     
                     <!-- Start Description Field -->
                     
                     <div class="row">
                         <div class="form-group form-group-lg">
                             <label class="col-sm-2 control-label">
                             Description</label>
                             <div class="col-sm-10 col-md-4">
                                 <input type='text'
                                        name="description" 
                                        class="form-control" 
                                        placeholder="Name Of The Description"/>
                             </div>
                         </div>
                     </div>
                     
                     <!-- End Description Field -->
                     
                     <!-- Start Price Field -->
                     
                     <div class="row">
                         <div class="form-group form-group-lg">
                             <label class="col-sm-2 control-label">
                             Price</label>
                             <div class="col-sm-10 col-md-4">
                                 <input type='text'
                                        name="price" 
                                        class="form-control" 
                                        placeholder="Price Of The Item"/>
                             </div>
                         </div>
                     </div>
                     
                     <!-- End Price Field -->
                     
                     <!-- Start Country Field -->
                     
                     <div class="row">
                         <div class="form-group form-group-lg">
                             <label class="col-sm-2 control-label">
                             Country</label>
                             <div class="col-sm-10 col-md-4">
                                 <input type='text'
                                        name="country" 
                                        class="form-control" 
                                        placeholder="Country Of Made"/>
                             </div>
                         </div>
                     </div>
                     
                     <!-- End Country Field -->
                     
                     <!-- Start Status Field -->
                     
                     <div class="row">
                         <div class="form-group form-group-lg">
                             <label class="col-sm-2 control-label">
                             Status</label>
                             <div class="col-sm-10 col-md-4">
                                <select class="form-control" name="status">
                                    <option value="0">...</option>
                                    <option value="1">New</option>
                                    <option value="2">Like New</option>
                                    <option value="3">Used</option>
                                    <option value="4">Very Old</option>
                                </select>
                             </div>
                         </div>
                     </div>
                     
                     <!-- End Status Field -->
                   
                     <!-- Start Members Field -->
                     
                     <div class="row">
                         <div class="form-group form-group-lg">
                             <label class="col-sm-2 control-label">
                             Member</label>
                             <div class="col-sm-10 col-md-4">
                                <select class="form-control" name="member">
                                    <option value="0">...</option>
                                    <?php
                                         $stmt = $con->prepare("SELECT * FROM users");
                                         $stmt->execute();
                                         $users = $stmt->fetchAll();
                                         foreach($users as $user){
                                             
                                             echo "<option value=".$user['UserID'].">".$user['Username']."</option>";
                                         }
                                    ?>
                                </select>
                             </div>
                         </div>
                     </div>
                     
                     <!-- End Members Field -->
                 
                     <!-- Start Category Field -->
                     
                         <div class="row">
                             <div class="form-group form-group-lg">
                                 <label class="col-sm-2 control-label">
                                 Category</label>
                                 <div class="col-sm-10 col-md-4">
                                    <select class="form-control" name="category">
                                        <option value="0">...</option>
                                        <?php
                                             $stmt2 = $con->prepare("SELECT * FROM categories");
                                             $stmt2->execute();
                                             $cats = $stmt2->fetchAll();
                                             foreach($cats as $cat){

                                                 echo "<option value=".$cat['ID'].">".$cat['Name']."</option>";
                                             }
                                        ?>
                                    </select>
                                 </div>
                             </div>
                         </div>
                     
                     <!-- End Category Field -->

                     <!-- Start Submit Field -->

                     <div class="form-group form-group-lg">
                         <div class="col-sm-offset-2 col-sm-10">
                             <input type='submit' value="Add Item" class="btn btn-primary btn-sm" />
                         </div>
                     </div>

                     <!-- End Submit Field -->

                 </form>
             </div>
              
          <?php


		} elseif ($do == 'Insert') {
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
                    // Get Variables From The Form

                    echo '<h1 class="text-center">Add Member</h1>';  
                    echo "<div class='container'>";

                    $name          = $_POST['name'];
                    $desc          = $_POST['description'];
                    $price         = $_POST['price'];
                    $country       = $_POST['country'];
                    $status        = $_POST['status'];
                    $member        = $_POST['member'];
                    $cat           = $_POST['category'];

                    // Validate form 

                    $formErrors = array();

                    if(empty($name)){

                        $formErrors[] = 'Name Can\'t Be <strong>Empty</strong>'; 

                    }
                    if(empty($desc)){

                        $formErrors[] = 'Description Can\'t Be <strong>Empty</strong>'; 
                    }
                    if(empty($price)){

                        $formErrors[] = 'Price Can\'t Be <strong>Empty</strong>'; 

                    }
                    if(empty($country)){

                        $formErrors[] = 'Country Can\'t Be <strong>Empty</strong>'; 

                    }
                    if($status==='0'){

                        $formErrors[] = 'You Must Choose The <strong>Status</strong>'; 

                    }
                   if($member==='0'){

                        $formErrors[] = 'You Must Choose The <strong>Member</strong>'; 

                    }
                   if($cat==='0'){

                        $formErrors[] = 'You Must Choose The <strong>Category</strong>'; 

                    }
                    foreach($formErrors as $error){

                        echo "<div class='alert alert-danger'>" .$error . '</div>';
                    }

                    // Check If There's No Error In Operation

                    if(empty($formErrors)){

 

                    // Insert Userinfo In Database

                    $stmt = $con-> prepare("INSERT INTO
                    
                    items(Name,Description,Price,Country_Made,Status,Add_Date,Cat_ID,Member_ID)
                    
                    VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcat, :zmember)");
                        
                    $stmt->execute(array(

                    'zname' => $name,
                    'zdesc' => $desc,
                    'zprice' => $price,
                    'zcountry' => $country,
                    'zstatus' => $status,
                    'zcat' => $cat,
                    'zmember' => $member

                    ));
                    // Echo Success Message

                    $msg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';
                    redirectHome($msg,'back');


                    } // end of empty(formerror)

            } // end Request Server 
            else{

             echo '<div class="container">';
             $msg =  '<div class="alert alert-danger">you can\'t Browse this page directly</div>';
             redirectHome($msg);
             echo '</div>';
            }

            echo "</div>";   


		} elseif ($do == 'Edit') {

                // Check If Get Request Item Is Numeric And Get Integer Value

                $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

                // Select All Data Depend On This Id

                $stmt = $con->prepare("SELECT * FROM items WHERE Item_ID=?");
                $stmt->execute(array($itemid));
                $item = $stmt->fetch();
                $count = $stmt->rowCount();

                if($count){?>

                     <h1 class="text-center">Edit Item</h1>

                     <div class="container">
                         <form class="form-horizontel" action="?do=Update" method="post">
                          <input type='hidden' name="itemid" value="<?php echo $itemid ?>">

                             <!-- Start Name Field -->

                             <div class="row">
                                 <div class="form-group form-group-lg">
                                     <label class="col-sm-2 control-label">
                                     Name</label>
                                     <div class="col-sm-10 col-md-4">
                                         <input type='text'
                                                name="name" 
                                                class="form-control" 
                                                placeholder="Name Of The Item"
                                                value="<?php echo $item['Name'] ?>" />
                                     </div>
                                 </div>
                             </div>

                             <!-- End Name Field -->

                             <!-- Start Description Field -->

                             <div class="row">
                                 <div class="form-group form-group-lg">
                                     <label class="col-sm-2 control-label">
                                     Description</label>
                                     <div class="col-sm-10 col-md-4">
                                         <input type='text'
                                                name="description" 
                                                class="form-control" 
                                                placeholder="Name Of The Description"
                                                value="<?php echo $item['Description'] ?>"/>
                                     </div>
                                 </div>
                             </div>

                             <!-- End Description Field -->

                             <!-- Start Price Field -->

                             <div class="row">
                                 <div class="form-group form-group-lg">
                                     <label class="col-sm-2 control-label">
                                     Price</label>
                                     <div class="col-sm-10 col-md-4">
                                         <input type='text'
                                                name="price" 
                                                class="form-control" 
                                                placeholder="Price Of The Item"
                                                value="<?php echo $item['Price'] ?>"/>
                                     </div>
                                 </div>
                             </div>

                             <!-- End Price Field -->

                             <!-- Start Country Field -->

                             <div class="row">
                                 <div class="form-group form-group-lg">
                                     <label class="col-sm-2 control-label">
                                     Country</label>
                                     <div class="col-sm-10 col-md-4">
                                         <input type='text'
                                                name="country" 
                                                class="form-control" 
                                                placeholder="Country Of Made"
                                                value="<?php echo $item['Country_Made'] ?>"/>
                                     </div>
                                 </div>
                             </div>

                             <!-- End Country Field -->

                             <!-- Start Status Field -->

                             <div class="row">
                                 <div class="form-group form-group-lg">
                                     <label class="col-sm-2 control-label">
                                     Status</label>
                                     <div class="col-sm-10 col-md-4">
                                        <select class="form-control" name="status">
                                            <option value="1" <?php if($item['Status']==1){echo 'selected';}?> >New</option>
                                            <option value="2" <?php if($item['Status']==2){echo 'selected';}?>>Like New</option>
                                            <option value="3" <?php if($item['Status']==3){echo 'selected';}?>>Used</option>
                                            <option value="4" <?php if($item['Status']==4){echo 'selected';}?>>Very Old</option>
                                        </select>
                                     </div>
                                 </div>
                             </div>

                             <!-- End Status Field -->

                             <!-- Start Members Field -->

                             <div class="row">
                                 <div class="form-group form-group-lg">
                                     <label class="col-sm-2 control-label">
                                     Member</label>
                                     <div class="col-sm-10 col-md-4">
                                        <select class="form-control" name="member">
                                            <?php
                                                 $stmt = $con->prepare("SELECT * FROM users");
                                                 $stmt->execute();
                                                 $users = $stmt->fetchAll();
                                                 foreach($users as $user){
                                                     
                                                    echo "<option value='" . $user['UserID'] . "'"; 
                                                    if ($item['Member_ID'] == $user['UserID']) { echo 'selected'; } 
                                                    echo ">" . $user['Username'] . "</option>";
                                                 }
                    
                                            ?>
                                        </select>
                                     </div>
                                 </div>
                             </div>

                             <!-- End Members Field -->

                             <!-- Start Category Field -->

                                 <div class="row">
                                     <div class="form-group form-group-lg">
                                         <label class="col-sm-2 control-label">
                                         Category</label>
                                         <div class="col-sm-10 col-md-4">
                                            <select class="form-control" name="category">
                                                <?php
                                                     $stmt2 = $con->prepare("SELECT * FROM categories");
                                                     $stmt2->execute();
                                                     $cats = $stmt2->fetchAll();
                                                     foreach($cats as $cat){

                                                    echo "<option value='" . $cat['ID'] . "'";
                                                    if ($item['Cat_ID'] == $cat['ID']) { echo ' selected'; }
                                                    echo ">" . $cat['Name'] . "</option>";  
                                                     }
                                                ?>
                                            </select>
                                         </div>
                                     </div>
                                 </div>

                             <!-- End Category Field -->

                             <!-- Start Submit Field -->

                             <div class="form-group form-group-lg">
                                 <div class="col-sm-offset-2 col-sm-10">
                                     <input type='submit' value="Save Item" class="btn btn-primary btn-sm" />
                                 </div>
                             </div>

                             <!-- End Submit Field -->

                         </form>
                        <?php

					// Select All Users Except Admin 

					$stmt = $con->prepare("SELECT 
												comments.*, users.Username AS Member  
											FROM 
												comments
											INNER JOIN 
												users 
											ON 
												users.UserID = comments.user_id
											WHERE item_id = ?");

					// Execute The Statement

					$stmt->execute(array($itemid));

					// Assign To Variable 

					$rows = $stmt->fetchAll();

					if (! empty($rows)) {
						
					?>
					<h1 class="text-center">Manage [ <?php echo $item['Name'] ?> ] Comments</h1>
					<div class="table-responsive">
						<table class="main-table text-center table table-bordered">
							<tr>
								<td>Comment</td>
								<td>User Name</td>
								<td>Added Date</td>
								<td>Control</td>
							</tr>
							<?php
								foreach($rows as $row) {
									echo "<tr>";
										echo "<td>" . $row['comment'] . "</td>";
										echo "<td>" . $row['Member'] . "</td>";
										echo "<td>" . $row['comment_date'] ."</td>";
										echo "<td>
											<a href='comments.php?do=Edit&comid=" . $row['c_id'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
											<a href='comments.php?do=Delete&comid=" . $row['c_id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
											if ($row['status'] == 0) {
												echo "<a href='comments.php?do=Approve&comid="
														 . $row['c_id'] . "' 
														class='btn btn-info activate'>
														<i class='fa fa-check'></i> Approve</a>";
											}
										echo "</td>";
									echo "</tr>";
								}
							?>
							<tr>
						</table>
					</div>
					<?php } ?>
				</div>          

            <?php

                  }else{

                    echo '<div class="container">';

                    $msg =  '<div class="alert alert-danger">There\'s No Such ID</div>';
                    redirectHome($msg);

                    echo '</div>';
                }

		} elseif ($do == 'Update') {

                echo "<h1 class='text-center'>Update Item</h1>";
                echo "<div class='container'>";

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    // Get Variables From The Form

                    $id 		= $_POST['itemid'];
                    $name 		= $_POST['name'];
                    $desc 		= $_POST['description'];
                    $price 		= $_POST['price'];
                    $country	= $_POST['country'];
                    $status 	= $_POST['status'];
                    $cat 		= $_POST['category'];
                    $member 	= $_POST['member'];

                    // Validate The Form

                    $formErrors = array();

                    if (empty($name)) {
                        $formErrors[] = 'Name Can\'t be <strong>Empty</strong>';
                    }

                    if (empty($desc)) {
                        $formErrors[] = 'Description Can\'t be <strong>Empty</strong>';
                    }

                    if (empty($price)) {
                        $formErrors[] = 'Price Can\'t be <strong>Empty</strong>';
                    }

                    if (empty($country)) {
                        $formErrors[] = 'Country Can\'t be <strong>Empty</strong>';
                    }

                    if ($status == 0) {
                        $formErrors[] = 'You Must Choose the <strong>Status</strong>';
                    }

                    if ($member == 0) {
                        $formErrors[] = 'You Must Choose the <strong>Member</strong>';
                    }

                    if ($cat == 0) {
                        $formErrors[] = 'You Must Choose the <strong>Category</strong>';
                    }

                    // Loop Into Errors Array And Echo It

                    foreach($formErrors as $error) {
                        echo '<div class="alert alert-danger">' . $error . '</div>';
                    }

                    // Check If There's No Error Proceed The Update Operation

                    if (empty($formErrors)) {

                        // Update The Database With This Info

                        $stmt = $con->prepare("UPDATE 
                                                    items 
                                                SET 
                                                    Name = ?, 
                                                    Description = ?, 
                                                    Price = ?, 
                                                    Country_Made = ?,
                                                    Status = ?,
                                                    Cat_ID = ?,
                                                    Member_ID = ?
                                                WHERE 
                                                    Item_ID = ?");

                        $stmt->execute(array($name, $desc, $price, $country, $status, $cat, $member, $id));

                        // Echo Success Message

                        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

                        redirectHome($theMsg, 'back');

                    }			
                } else {

				$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

				redirectHome($theMsg);

		      	}

			echo "</div>";


		} elseif ($do == 'Delete') {

			echo "<h1 class='text-center'>Delete Item</h1>";
			echo "<div class='container'>";

				// Check If Get Request Item ID Is Numeric & Get The Integer Value Of It

				$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

				// Select All Data Depend On This ID

				$check = checkItem('Item_ID', 'items', $itemid);

				// If There's Such ID Show The Form

				if ($check > 0) {

					$stmt = $con->prepare("DELETE FROM items WHERE Item_ID = :zid");

					$stmt->bindParam(":zid", $itemid);

					$stmt->execute();

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';

					redirectHome($theMsg, 'back');

				} else {

					$theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';

					redirectHome($theMsg);

				}

			echo '</div>';

		} elseif ($do == 'Approve') {
             
            echo "<h1 class='text-center'>Approve Item</h1>";
			echo "<div class='container'>";

				// Check If Get Request Item ID Is Numeric & Get The Integer Value Of It

				$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

				// Select All Data Depend On This ID

				$check = checkItem('Item_ID', 'items', $itemid);

				// If There's Such ID Show The Form

				if ($check > 0) {

					$stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ?");

					$stmt->execute(array($itemid));

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

					redirectHome($theMsg, 'back');

				} else {

					$theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';

					redirectHome($theMsg);

				}

			echo '</div>';

		}

		include $tpl . 'footer.php';

	} else {

		header('Location: index.php');

		exit();
	}


?>