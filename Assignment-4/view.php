<?php

    session_start();

    try 
    {
        if ( ! isset($_SESSION['name']) ) {
            die('Not logged in');
        }
    
        $name = htmlentities($_SESSION['name']);
    
        $username = "root";  
        $password = ""; 

        $db = new PDO('mysql:host=localhost;dbname=assignment_2_coursera', $username , $password);   //making connection with the database
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $show_data = [];
        $sql = $db->query("SELECT * FROM autos");
        
        while ( $row = $sql->fetch(PDO::FETCH_OBJ) ) 
        {
            $show_data[] = $row;     // piling up the data into an array 
        }
        
    }
    catch (Exception $ex )
    { 
        echo("Internal error, please contact support");
        error_log("view.php,  Error=".$ex->getMessage() );
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
            if ( isset($_SESSION['success']) ) {
                echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
                unset($_SESSION['success']);
            }
        ?>
        
        <h2> Automobiles </h2>

        <?php if(!empty($show_data)) { ?>   <!-- Running the loop to append the data into the list which is piled above -->
                 <ul>
                    <?php foreach($show_data as $auto) { ?>
                        <li>
                            <?php echo $auto->year .  " " .   $auto->make  . " / " .  $auto->mileage; ?> 
                        </li>
                    <?php } ?>
                </ul>
        <?php } ?>


        <form method= "POST">
        
            <p>
                <a href="add.php" class="btn btn-primary">Add New</a>
				<a href="logout.php" class="btn btn-default">Logout</a>
            </p>

        </form>

       
  </body>
</html>