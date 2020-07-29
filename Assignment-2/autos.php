<?php

   
    try 
    {

        // checking the url is name parameter is present or not 
        if ( !isset($_GET['name']) || strlen($_GET['name']) < 1 ) {
            die('Name parameter missing');
        }
      
        if ( strpos($_GET['name'], '@') === false )
        {
            die('Name parameter is wrong');
        }
    
        
        // If the usere requested to logout from the autos.php then go to index.php
        if ( isset($_POST['logout_btn']) )
        {
            header('Location: index.php');
            return;
        }

    
        $name = htmlentities($_GET['name']);
        $status = true;         // this is the flag to check the status
        $status_color = 'red'; //  and this flag is to color the status in the specified color

    
        $username = "root";  
        $password = ""; 

        $db = new PDO('mysql:host=localhost;dbname=assignment_2_coursera', $username , $password);   //making connection with the database
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        if (isset($_POST['mileage']) && isset($_POST['year']) && isset($_POST['make'])) 
        {
            if ( !is_numeric($_POST['mileage']) || !is_numeric($_POST['year']) ) 
            {
                $status = "Mileage and year must be numeric";
            } 
            else if (strlen($_POST['make']) < 1)
            {
                $status = "Make is required";
            }
            else 
            {
                
                // using prepared statement to insert the data into the database
                $insert_query = "INSERT INTO `assignment_2_coursera`.`autos`( `make`, `year`, `mileage`) VALUES (:make,:years,:mileage)";
                $stmt = $db->prepare($insert_query);
            
                $stmt->execute(array(
                                    ':make' =>  htmlentities($_POST['make']),
                                    ':years' => htmlentities($_POST['year']),
                                    ':mileage' => htmlentities($_POST['mileage'])
                                ));
                
                if ( $stmt->rowCount() )     // if the data is inserted successfully then we enter the if block
                {
                    // echo "<br> <br>  Record inserted successfully: 1 Row Affected";
                    $status = 'Record inserted';
                    $status_color = 'green';
                } 
                else 
                {  
                    $status = 'Insertion Failed due to some internal errors';
                    $status_color = 'red';
                    // and if the insertion is failed the control goe to the catch block
                }
            
            }
        }


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
    
        <script type="text/javascript">

             

        </script>
    </head>
  
  
    <body>
   
        <h1>
            Tracking Autos for <?php  echo $name; ?>
        </h1>
        
        <?php
                if ( $status !== true ) 
                {
                    // Look closely at the use of single and double quotes
                    echo(
                        '<p style="color: ' .$status_color. ';" class="col-sm-10 col-sm-offset-2">'.
                            htmlentities($status).
                        "</p>\n"
                    );
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
                <button type="submit" name= "logout_btn"  class="btn btn-outline-primary">logout</button>
            </div>
        
        </form>

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


       
  </body>
</html>