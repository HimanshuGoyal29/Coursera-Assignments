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

        $db = new PDO('mysql:host=localhost;dbname=5_assignment_coursera', $username , $password);   //making connection with the database
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
   
        <h1>Welcome to the Automobiles Database</h1>


        <?php
            if ( isset($_SESSION['error']) )
            {
                echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
                unset($_SESSION['error']);
            }
            if ( isset($_SESSION['success']) )
            {
                echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
                unset($_SESSION['success']);
            }
        ?>
        

        <?php if (empty($show_data)) { ?>
                <p>No rows found</p>
        <?php } else { ?>
                <p>
                    <table  class="table">
                        <thead>
                            <tr>
                                <th>Make</th>
                                <th>Model</th>
                                <th>Year</th>
                                <th>Mileage</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($show_data as $auto) {?>
                                <tr>
                                    <td><?php echo $auto->make; ?></td>
                                    <td><?php echo $auto->model; ?></td>
                                    <td><?php echo $auto->year; ?></td>
                                    <td><?php echo $auto->mileage; ?></td>
                                    <td><a href="edit.php?user_id=<?php echo $auto->autos_id; ?>">Edit</a> / <a href="delete.php?user_id=<?php echo $auto->autos_id; ?>">Delete</a></td>
                                </tr>
                            <?php }?>
                            </tbody>
                    </table>
                </p>
        <?php }?>



        <p>
            <a href="add.php">Add New Entry</a>
        </p>
        <p>
            <a href="logout.php">Logout</a>
        </p>

        <p>
            <b>Note:</b> Your implementation should retain data across multiple logout/login sessions. 
            This sample implementation clears all its data on logout - which you should not do in your implementation.
        </p>
  </body>
</html>