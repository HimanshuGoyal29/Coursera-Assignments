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
          //  echo "<br> <br>  Record fetched successfully: 1 Row Affected";
            $make = htmlentities($row['make']);
            $model = htmlentities($row['model']);
            $year = htmlentities($row['year']);
            $mileage = htmlentities($row['mileage']);
        } 
        else 
        {  
            echo "<br> <br> Cannot delete a record with given id";
        }
    
    
                
        if (isset($_POST['mileage']) && isset($_POST['mileage']) && isset($_POST['year']) && isset($_POST['make'])) 
        {
            if (strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1 )
            {

                $_SESSION['error'] = "All values are required";
                header("Location: edit.php?user_id=" . htmlentities($_GET['user_id']) );
                return;
            }
            else if ( !is_numeric($_POST['mileage']) || !is_numeric($_POST['year']) ) 
            {

                $_SESSION['error'] = "Year must be an integer";
                header("Location: edit.php?user_id=" . htmlentities($_GET['user_id']) );
                return;
            } 
            else 
            {
                
                // using prepared statement to insert the data into the database
                $update_query = " UPDATE `autos` SET `autos_id`=:userid,`make`=:make,`model`=:model,`year`=:years,`mileage`=:mileage WHERE `autos_id`=:userid  "; 
                $stmt = $db->prepare($update_query);
            
                $stmt->execute(array(
                                    ':userid' =>  htmlentities($_GET['user_id']),
                                    ':make' =>  htmlentities($_POST['make']),
                                    ':model' =>  htmlentities($_POST['model']),
                                    ':years' => htmlentities($_POST['year']),
                                    ':mileage' => htmlentities($_POST['mileage'])
                                ));
                
                if ( $stmt->rowCount() )     // if the data is updated successfully then we enter the if block
                {
                    // echo "<br> <br>  Record updated successfully: 1 Row Affected";

                    $_SESSION['success'] = "Record updated";
                    header("Location: index.php");
                    return;
                } 
                else 
                {  

                    $_SESSION['error'] = "Updation failed due to some internal errors";
                    header("Location: edit.php?user_id=" . htmlentities($_GET['user_id']) );
                    return;                    
                    // and if the insertion is failed the control goes to the catch block
                }
            
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
   
        <h1>
            Tracking Autos for <?php  echo $_SESSION['name']; ?>
        </h1>
        
        <?php
               if ( isset($_SESSION['error']) ) 
               {
                   echo(  '<p style="color: red;" class="col-sm-10 col-sm-offset-2">'. htmlentities($_SESSION['error']). "</p> \n"  );
                   unset($_SESSION['error']);
               }
        ?>



        <form method= "POST">
            
            <div class="form-group row">
                <label for="inputMake" class="col-sm-1 col-form-label">Make</label>
                <div class="col-sm-4">
                  <input type="text" name="make"  class="form-control" id="Make" value="<?php echo $make ?>">
                </div>
            </div>
  
            <div class="form-group row">
                <label for="inputModel" class="col-sm-1 col-form-label">Model</label>
                <div class="col-sm-4">
                  <input type="text" name="model"  class="form-control" id="model"  value="<?php echo $model ?>">
                </div>
            </div>
          
            <div class="form-group row">
                <label for="inputYear" class="col-sm-1 col-form-label">Year</label>
                <div class="col-sm-4">
                  <input type="text" name="year"  class="form-control" id="Year"  value="<?php echo $year ?>">
                </div>
            </div>
          
            <div class="form-group row">
                <label for="inputMileage" class="col-sm-1 col-form-label">Mileage</label>
                <div class="col-sm-4">
                  <input type="text" name="mileage"  class="form-control" id="mileage"   value="<?php echo $mileage ?>">
                </div>
            </div>
           
            <div>
                <button type="submit" name= "save_btn" class="btn btn-outline-primary">Save</button>
                <button type="submit" name= "cancel_btn"  class="btn btn-outline-primary">Cancel</button>
            </div>
        
        </form>
       
  </body>
</html>




