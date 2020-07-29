<?php

   
session_start();

    try 
    {
        if ( ! isset($_SESSION['name']) ) {
            die('ACCESS DENIED');
        }
        
        // If the user requested to logout from the autos.php then go to index.php
        if ( isset($_POST['cancel_btn']) )
        {
            header('Location: index.php');
            return;
        }


        $name = htmlentities($_SESSION['name']);
        $_SESSION['color'] = 'red';
    
        $username = "root";  
        $password = ""; 

        $db = new PDO('mysql:host=localhost;dbname=5_assignment_coursera', $username , $password);   //making connection with the database
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        if (isset($_POST['mileage']) && isset($_POST['mileage']) && isset($_POST['year']) && isset($_POST['make'])) 
        {
            if (strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1 )
            {
   
                $_SESSION['error'] = "All fields are required";
                header("Location: add.php");
                return;
            }
            else if ( !is_numeric($_POST['mileage']) || !is_numeric($_POST['year']) ) 
            {
   
                $_SESSION['error'] = "Year must be an integer";
                header("Location: add.php");
                return;
            } 
            else 
            {
                
                // using prepared statement to insert the data into the database
                $insert_query = " INSERT INTO `autos`(`make`, `model`, `year`, `mileage`) VALUES (:make,:model,:years,:mileage)";
                $stmt = $db->prepare($insert_query);
            
                $stmt->execute(array(
                                    ':make' =>  htmlentities($_POST['make']),
                                    ':model' =>  htmlentities($_POST['model']),
                                    ':years' => htmlentities($_POST['year']),
                                    ':mileage' => htmlentities($_POST['mileage'])
                                ));
                
                if ( $stmt->rowCount() )     // if the data is inserted successfully then we enter the if block
                {
                    // echo "<br> <br>  Record inserted successfully: 1 Row Affected";
   
                    $_SESSION['success'] = "Record added";
                    header("Location: index.php");
                    return;
                } 
                else 
                {  

                    $_SESSION['error'] = "Insertion failed due to some internal errors";
                    header("Location: add.php");
                    return;                    
                    // and if the insertion is failed the control goes to the catch block
                }
            
            }
        }
        
    }
    catch (Exception $ex )
    { 
        echo("Internal error, please contact support");
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
            Tracking Autos for <?php  echo $name; ?>
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
                  <input type="text" name="make"  class="form-control" id="Make">
                </div>
            </div>
  
            <div class="form-group row">
                <label for="inputModel" class="col-sm-1 col-form-label">Model</label>
                <div class="col-sm-4">
                  <input type="text" name="model"  class="form-control" id="model">
                </div>
            </div>
          
            <div class="form-group row">
                <label for="inputYear" class="col-sm-1 col-form-label">Year</label>
                <div class="col-sm-4">
                  <input type="text" name="year"  class="form-control" id="Year">
                </div>
            </div>
          
            <div class="form-group row">
                <label for="inputMileage" class="col-sm-1 col-form-label">Mileage</label>
                <div class="col-sm-4">
                  <input type="text" name="mileage"  class="form-control" id="mileage">
                </div>
            </div>
           
            <div>
                <button type="submit" name= "add_btn" class="btn btn-outline-primary">Add</button>
                <button type="submit" name= "cancel_btn"  class="btn btn-outline-primary">Cancel</button>
            </div>
        
        </form>
       
  </body>
</html>