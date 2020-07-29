<?php

   
session_start();

    // Guardian: Make sure that user_id is present
    if ( ! isset($_GET['user_id']) ) {
        $_SESSION['error'] = "Missing user_id";
        header('Location: index.php');
        return;
    }
   
    if ( ! isset($_SESSION['name']) ) {
        die('ACCESS DENIED');
    }

    try 
    {
       
        
        // If the user requested to logout from the autos.php then go to index.php
        if ( isset($_POST['cancel_btn']) )
        {
            header('Location: index.php');
            return;
        }

    
        $username = "root";  
        $password = ""; 
    
        $db = new PDO('mysql:host=localhost;dbname=5_assignment_coursera', $username , $password);   //making connection with the database
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        


        $select_query = "SELECT * FROM `autos` WHERE autos_id = :id";
    
        $sql = $db->prepare($select_query);
        $sql->execute( array( ':id' => $_GET['user_id'] ));
        $row = $sql->fetch(PDO::FETCH_ASSOC);
    
        if ( $sql->rowCount() ) 
        {
           $make = htmlentities($row['make']);
        } 
        else 
        {  
            echo "<br> <br> Cannot delete a record with given id";
        }
    
    
            
        if (isset($_POST['delete_btn']) ) 
        {
            
            // using prepared statement to insert the data into the database
            $delete_query = "DELETE FROM `autos` WHERE autos_id = :userid "; 
      
            $stmt = $db->prepare($delete_query);
        
            $stmt->execute(array( ':userid' =>  htmlentities($_GET['user_id']) ));
            
            if ( $stmt->rowCount() )     // if the data is updated successfully then we enter the if block
            {
                // echo "<br> <br>  Record delete successfully: 1 Row Affected";

                $_SESSION['success'] = "Record deleted";
                header("Location: index.php");
                return;
            } 
            else 
            {  

                $_SESSION['error'] = "Deletion failed due to some internal errors";
                header("Location: edit_1.php?user_id=" . htmlentities($_GET['user_id']) );
                return;                    
                // and if the deletion is failed the control goes to the catch block
            }
        
        }
    
    
        
    }
    catch (Exception $ex )
    { 
         echo("Internal error, please contact support" .$ex->getMessage() );
        error_log("autos.php,  Error=".$ex->getMessage() );
         return;
    }


    
    
?>



<!doctype html>
<html lang="en">
  
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

        <title>Himanshu Goyal</title>

        <style>
            *{
                padding: 4px;
            }
        </style>

    </head>
  
  
    <body>
   
        <p>
            Confirm: Deleting <?php echo $make; ?>
        </p>

        <form method= "POST">
            
           <div>
                <button type="submit" name= "delete_btn" class="btn btn-outline-primary">Delete</button>
                <button type="submit" name= "cancel_btn"  class="btn btn-outline-primary">Cancel</button>
            </div>
        
        </form>
       
  </body>
</html>




