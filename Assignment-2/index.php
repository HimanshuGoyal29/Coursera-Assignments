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

            function error_message()
            {
               alert("You need to log in first, only then you can access autos.php module");
               
               return false;
            }    

        </script>
    </head>
  
  <body>
   
        <h1>Welcome to Autos Database</h1>

        <p>
            <a href="login.php"> Please Log In </a> 
        </p>

        <p>
            Attempt to go to 
            <a  href="autos.php" onclick=" return error_message()">autos.php</a> 
			without logging in - it should fail with an error message. 
        </p>

        <p>
            <a href="https://www.wa4e.com/assn/autosdb/" > Specification for this Application </a>
        </p>
        
  </body>
</html>