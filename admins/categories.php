<?php 

    /*

    =================================================
    ==== Category Page
    =================================================

    */


    session_start();

    $pageTitle = 'Categories';

    if(isset ($_SESSION['Username'])){

        include "init.php";
        
        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ; 

        if($do=='Manage'){
            
			$sort = 'asc';

			$sort_array = array('asc', 'desc');

			if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {

				$sort = $_GET['sort'];

			}
            
            $stmt2 = $con->prepare("SELECT * FROM categories Order BY Ordering $sort");
            $stmt2->execute();
            $cats=$stmt2->fetchAll(); ?>
            
            <h1 class="text-center">Manage Category</h1>
            <div class="container categories">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fas fa-edit"></i>Manage Categories
                        <div class="option pull-right">
                            <i class="fas fa-sort"></i>ordering: [
                            <a class="<?php if($sort=='asc'){echo 'active';} ?>"href="?sort=asc">Asc</a>
                            <a class="<?php if($sort=='desc'){echo 'active';} ?>" href="?sort=desc">Desc</a>]
                            <i class="fa fa-eye"></i> View: [
							<span class="active" data-view="full">Full</span> |
							<span data-view="classic">Classic</span> ]
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php
                          
                           foreach($cats as $cat){
                               echo "<div class='cat'>";
									echo "<div class='hidden-buttons'>";
										echo "<a href='?do=Edit&catid=".$cat['ID'] ."' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i> Edit</a>";
										echo "<a href='?do=Delete&catid=".$cat['ID'] ."' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i> Delete</a>";
									echo "</div>";
                                   echo "<h3>" . $cat['Name'] . '</h3>';
                                   echo "<div class='full-view'>";
                                       echo "<p>";  if( $cat['Description']==''){echo 'This Category Has No Description';}else{echo $cat['Description']; } echo "</p>";
                                       if($cat["Visibility"]){echo "<span class='visibility'><i class='fas fa-eye'></i>Hidden</span>";}
                                       if($cat["Allow_Comment"]){echo "<span class='commenting'><i class='fas fa-window-close'></i>Comment Disable</span>";}
                                       if($cat["Allow_Ads"]){echo "<span class='advertises'><i class='fas fa-window-close'></i>Ads Disable</span>";}
                                   echo "</div>";
                               echo "</div>";
                               echo "<hr>";

                           }
                             
                        ?>
                    </div>
                </div>
                <a class="add-category btn btn-primary" href="categories.php?do=Add"><i class="fa fa-plus"></i> Add New Category</a>

            </div>
        
         <?php
            
        }elseif($do=='Add'){ ?>
            
             <h1 class="text-center">Add New Category</h1>

             <div class="container">
                 <form class="form-horizontel" action="?do=Insert" method="post">
                     
                     <!-- Start Name Field -->
                     <div class="row">
                         <div class="form-group form-group-lg">
                             <label class="col-sm-2 control-label">
                             Name</label>
                             <div class="col-sm-10 col-md-4">
                                 <input type='text' name="name" class="form-control" autocomplete='off' required='required' placeholder="Name Of Category"/>
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
                                 <input type='text' name="description" class="form-control" placeholder='Describe The Category'/>
                             </div>
                         </div>
                    </div>
                     <!-- End Description Field -->

                     <!-- Start Ordering Field -->
                     <div class="row">
                         <div class="form-group form-group-lg">
                             <label class="col-sm-2  control-label">
                             Ordering</label>
                             <div class="col-sm-10 col-md-4">
                                 <input type='text' name="ordering" class="form-control" placeholder="Number To Arrange The Category"/>
                             </div>
                         </div>
                     </div>
                     <!-- End Ordering Field -->

                     <!-- Start Visibilty Field -->
                     <div class="row">
                         <div class="form-group form-group-lg">
                             <label class="col-sm-2 control-label">
                             Visible</label>
                             <div class="col-sm-10 col-md-4">
                                <div>
                                    <input id="vis-yes" type="radio" name="visibility" value="0" checked />
                                    <label for="vis-yes">Yes</label> 
                                </div>
                                <div>
                                    <input id="vis-no" type="radio" name="visibility" value="1" />
                                    <label for="vis-no">No</label> 
                                </div>
                             </div>
                         </div>
                    </div>
                    <!-- End Visibilty Field -->      

					<!-- Start Commenting Field -->
                    <div class="row">
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Allow Commenting</label>
                            <div class="col-sm-10 col-md-6">
                                <div>
                                    <input id="com-yes" type="radio" name="commenting" value="0" checked />
                                    <label for="com-yes">Yes</label> 
                                </div>
                                <div>
                                    <input id="com-no" type="radio" name="commenting" value="1" />
                                    <label for="com-no">No</label> 
                                </div>
                            </div>
                        </div>
                    </div>
					<!-- End Commenting Field -->
                     
					<!-- Start Ads Field -->
                    <div class="row">
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Allow Ads</label>
                            <div class="col-sm-10 col-md-6">
                                <div>
                                    <input id="ads-yes" type="radio" name="ads" value="0" checked />
                                    <label for="ads-yes">Yes</label> 
                                </div>
                                <div>
                                    <input id="ads-no" type="radio" name="ads" value="1" />
                                    <label for="ads-no">No</label> 
                                </div>
                            </div>
                        </div>
                    </div>
					<!-- End Ads Field -->

                     <!-- Start Submit Field -->

                     <div class="form-group form-group-lg">
                         <div class="col-sm-offset-2 col-sm-10">
                             <input type='submit' value="Add Category" class="btn btn-primary btn-lg" />
                         </div>
                     </div>

                     <!-- End Submit Field -->

                 </form>
             </div>
              
          <?php 
            
        }elseif($do=='Insert'){ 
            
       
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // Get Variables From The Form

                echo '<h1 class="text-center">Update Category</h1>';  
                echo "<div class='container'>";

                $name       = $_POST['name'];
                $desc       = $_POST['description'];
                $order      = $_POST['ordering'];
                $visible    = $_POST['visibility'];
                $comment    = $_POST['commenting'];
                $ads        = $_POST['ads'];

                // Validate form 


               // Check If Category Exist In Database
                
               $check = checkItem('Name','categories',$name); 

               if(!$check){

					// Insert Category Info In Database

					$stmt = $con->prepare("INSERT INTO 
						categories(Name, Description, Ordering, Visibility, Allow_Comment, Allow_Ads)
					VALUES(:zname, :zdesc,:zorder, :zvisible, :zcomment,:zads)");

					$stmt->execute(array(
						'zname' 	=> $name,
						'zdesc' 	=> $desc,
						'zorder' 	=> $order,
						'zvisible' 	=> $visible,
						'zcomment' 	=> $comment,
						'zads'		=> $ads
					));
                   
                     // Echo Success Message

                    $msg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';
                     redirectHome($msg,'back');




               }else{

                   $msg = '<div class="alert alert-danger">Sorry This Category Already Exist</div>';
                   redirectHome($msg,'back');
               }



            } // request
            else{

                 echo '<div class="container">';
                 $msg =  '<div class="alert alert-danger">you can\'t Browse this page directly</div>';
                 redirectHome($msg);
                 echo '</div>';
            }

           echo "</div>";       


        } // else if
        elseif($do=='Edit'){
            
        // Check If Get Request Is Numeric And Get Integer Value
        
        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
        
        // Select All Data Depend On This Id
        
        $stmt = $con->prepare("SELECT * FROM categories WHERE ID=?");
        $stmt->execute(array($catid));
        $cat = $stmt->fetch();
        $count = $stmt->rowCount();
        
            if($count){?>

                 <h1 class="text-center">Edit Category</h1>

                 <div class="container">
                     <form class="form-horizontel" action="?do=Update" method="post">
                     <input type='hidden' name="catid" value="<?php echo $catid ?>">

                         <!-- Start Name Field -->
                         <div class="row">
                             <div class="form-group form-group-lg">
                                 <label class="col-sm-2 control-label">
                                 Name</label>
                                 <div class="col-sm-10 col-md-4">
                                     <input type='text' name="name" class="form-control" required='required' placeholder="Name Of Category" value = "<?php echo $cat['Name'] ?>"/>
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
                                     <input type='text' name="description" class="form-control" placeholder='Describe The Category' value = "<?php echo $cat['Description'] ?>"/>
                                 </div>
                             </div>
                        </div>
                         <!-- End Description Field -->

                         <!-- Start Ordering Field -->
                         <div class="row">
                             <div class="form-group form-group-lg">
                                 <label class="col-sm-2  control-label">
                                 Ordering</label>
                                 <div class="col-sm-10 col-md-4">
                                     <input type='text' name="ordering" class="form-control" placeholder="Number To Arrange The Category" value = "<?php echo $cat['Ordering'] ?>"/>
                                 </div>
                             </div>
                         </div>
                         <!-- End Ordering Field -->

                         <!-- Start Visibilty Field -->
                         <div class="row">
                             <div class="form-group form-group-lg">
                                 <label class="col-sm-2 control-label">
                                 Visible</label>
                                 <div class="col-sm-10 col-md-4">
                                    <div>
                                        <input id="vis-yes" type="radio" name="visibility" value="0" <?php if($cat['Visibility']==0){echo 'checked';} ?> />
                                        <label for="vis-yes">Yes</label> 
                                    </div>
                                    <div>
                                        <input id="vis-no" type="radio" name="visibility" value="1" <?php if($cat['Visibility']==1){echo 'checked';} ?>/>
                                        <label for="vis-no">No</label> 
                                    </div>
                                 </div>
                             </div>
                        </div>
                        <!-- End Visibilty Field -->      

                        <!-- Start Commenting Field -->
                        <div class="row">
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Allow Commenting</label>
                                <div class="col-sm-10 col-md-6">
                                    <div>
                                        <input id="com-yes" type="radio" name="commenting" value="0" <?php if($cat['Allow_Comment']==0){echo 'checked';} ?> />
                                        <label for="com-yes">Yes</label> 
                                    </div>
                                    <div>
                                        <input id="com-no" type="radio" name="commenting" value="1" <?php if($cat['Allow_Comment']==1){echo 'checked';} ?>/>
                                        <label for="com-no">No</label> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Commenting Field -->

                        <!-- Start Ads Field -->
                        <div class="row">
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Allow Ads</label>
                                <div class="col-sm-10 col-md-6">
                                    <div>
                                        <input id="ads-yes" type="radio" name="ads" value="0" <?php if($cat['Allow_Ads']==0){echo 'checked';} ?> />
                                        <label for="ads-yes">Yes</label> 
                                    </div>
                                    <div>
                                        <input id="ads-no" type="radio" name="ads" value="1" <?php if($cat['Allow_Ads']==1){echo 'checked';} ?>/>
                                        <label for="ads-no">No</label> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Ads Field -->

                         <!-- Start Submit Field -->

                         <div class="form-group form-group-lg">
                             <div class="col-sm-offset-2 col-sm-10">
                                 <input type='submit' value="Save Category" class="btn btn-primary btn-lg" />
                             </div>
                         </div>

                         <!-- End Submit Field -->

                     </form>
                 </div>

             <?php
               }  
                else{

                        echo '<div class="container">';

                        $msg =  '<div class="alert alert-danger">There\'s No Such ID</div>';
                        redirectHome($msg);

                        echo '</div>';
                }
             
        } elseif($do=='Update'){

            echo '<h1 class="text-center">Update Category</h1>';  
            echo "<div class='container'>";

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // Get Variables From The Form

				$id 		= $_POST['catid'];
				$name 		= $_POST['name'];
				$desc 		= $_POST['description'];
				$order 		= $_POST['ordering'];
				$visible 	= $_POST['visibility'];
				$comment 	= $_POST['commenting'];
				$ads 		= $_POST['ads'];

				// Update The Database With This Info

				$stmt = $con->prepare("UPDATE 
											categories 
										SET 
											Name = ?, 
											Description = ?, 
											Ordering = ?, 
											Visibility = ?,
											Allow_Comment = ?,
											Allow_Ads = ? 
										WHERE 
											ID = ?");

				$stmt->execute(array($name, $desc, $order,$visible, $comment, $ads, $id));

				// Echo Success Message

				$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

				redirectHome($theMsg, 'back');


               
            }else{

                $msg =  '<div class="alert alert-danger">you can\'t Browse this page directly</div>';
                redirectHome($msg);

            }

           echo "</div>";


        }elseif($do=='Delete'){  
            
            echo "<h1 class='text-center'>Delete Category</h1>";
			echo "<div class='container'>";

				// Check If Get Request Catid Is Numeric & Get The Integer Value Of It

				$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

				// Select All Data Depend On This ID

				$check = checkItem('ID', 'categories', $catid);

				// If There's Such ID Show The Form

				if ($check > 0) {

					$stmt = $con->prepare("DELETE FROM categories WHERE ID = :zid");

					$stmt->bindParam(":zid", $catid);

					$stmt->execute();

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';

					redirectHome($theMsg, 'back');

				} else {

					$theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';

					redirectHome($theMsg);

				}

			echo '</div>';

        } 
        
        include $tpl . "footer.php";

    } // End Session Username
    else{

    header('Location : index.php');
    exit();

    }
