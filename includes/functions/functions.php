<?php





   /*
    
    -- Get Latest Categories V1
    -- Function Get Lates categories From Database [users,items,comments]

   
   */

    function getCat(){
        
        global $con;
        $getStmt = $con->prepare("SELECT * FROM categories");
        $getStmt->execute();
        $rows = $getStmt->fetchAll();
        return $rows;
        
    }

   /*
    
    -- Get Latest Items V1
    -- Function Get Lates Items From Database [users,items,comments]

   
   */

    function getItem(){
        
        global $con;
        $getItems = $con->prepare("SELECT * FROM items ORDER BY Item_ID ASC");
        $getItems->execute();
        $items = $getItems->fetchAll();
        return $items;
        
    }

   /*
    
    -- Get Latest Items V1
    -- Function Get Lates Items From Database [users,items,comments]

   
   */

    function getItemUser($value){
        
        global $con;
        $getItems = $con->prepare("SELECT * FROM items WHERE Member_ID = ? ORDER BY Item_ID DESC");
        $getItems->execute(array($value));
        $items = $getItems->fetchAll();
        return $items;
        
    }

   


    /*
	** Check If User Is Not Activated
	** Function To Check The RegStatus Of The User
	*/

	function checkUserStatus($user) {

		global $con;

		$stmtx = $con->prepare("SELECT 
									Username, RegStatus 
								FROM 
									users 
								WHERE 
									Username = ? 
								AND 
									RegStatus = 0");

		$stmtx->execute(array($user));

		$status = $stmtx->rowCount();

		return $status;

	}













    /*
    -- Title function that echo page title in case the page
    -- Has Variable $pagetitle that echo dafault title for otjher pages
    
    */


    function getTitle(){
        
        global $pageTitle;
        
        if(isset($pageTitle)){
            
            echo $pageTitle;
            
        }else{
            
            echo 'Default';
        }
        
        
    }


    /* 
    -- V1 
    -- Redirect Function And This Function Accept Parameter
    -- $errorMsg = Echo The Error Message
    -- $seconds  = Seconds Before Redirecting
    
        function redirectHome($errorMsg, $seconds = 3){
        
        echo "<div class='alert alert-danger'>$errorMsg </div>";
        echo "<div class='alert alert-info'>You Will Be Redirected To Homepage After$seconds Seconds. </div>";
        
        header("refresh:$seconds;url=index.php");
        exit();
      
    }

    */


    /*
    -- V2
    -- Redirect Function And This Function Accept Parameter
    -- $errorMsg = Echo The Message
    -- $seconds  = Seconds Before Redirecting
    
    

    */

    function redirectHome($theMsg,$url= null, $seconds = 3){
        
        if($url === null){
            
            $url = 'index.php';
            $link = 'HomePage';
        }else{
                    $url =$_SERVER['HTTP_REFERER'];
                    $link = 'Previous Page';

        }
        echo $theMsg;
        echo "<div class='alert alert-info'>You Will Be Redirected To $link After $seconds Seconds. </div>";
        
        header("refresh:$seconds;url=$url");
        exit();
        
    }


    function checkItem($select,$from,$value){
        
        global $con;
        $statement = $con->prepare("SELECT $select FROM $from WHERE $select=?");
        
        $statement->execute(array($value));
        $count = $statement->rowCount();
        return $count;
        
    }


    /*
    -- v1
    -- Count Number Of Items 
    -- Function Count Number Of items Rows
    -- $item = item to count
    -- $table = the table to choose from
    */

    function countItems($item,$table){
        
       global $con;    
       $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");
       $stmt2->execute();
       return $stmt2->fetchcolumn();
        
    }
    
    
   /*
    
    -- Get Latest Records V1
    -- Function Get Lates Items From Database [users,items,comments]
    -- $Select -> Failed To Select
    -- $Table  -> Table U Will Choose From
    -- $order  -> The Desc Ordering'
    -- $Limit  -> Number Of Record To Get
   
   */

    function getLatest($select,$table,$order,$limit = 5){
        
        global $con;
        $getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
        $getStmt->execute();
        $rows = $getStmt->fetchAll();
        return $rows;
        
    }


	function getAllFrom($field, $table, $where = NULL, $and = NULL, $orderfield, $ordering = "DESC") {

		global $con;

		$getAll = $con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering");

		$getAll->execute();

		$all = $getAll->fetchAll();

		return $all;

	}


    