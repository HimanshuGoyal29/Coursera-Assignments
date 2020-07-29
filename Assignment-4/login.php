<?php
    
    session_start();

    if ( isset($_POST['cancel_btn'] ) ) {

        header("Location: logout.php");  //redirecting the page to index.php 
        return;
    }

    $salt = 'XyZzy12*_';
    $stored_hash= '1a52e17fa899cf40fb04cfc42e6352f1'; // this hash is created using the method: hash('md5', $salt.$pass); where password is "php123" and salt is given above4
    
    
    if ( isset($_POST['email']) && isset($_POST['pass']) ) 
    {
        if(strlen($_POST['email'])<1 || strlen($_POST['pass']) < 1)   // checking if email and password are are not empty
        {
    
            $_SESSION['error'] = "Email and Password are Required";
            header("Location: login.php");
            return;
        }
        else
        {
            $email = htmlentities($_POST['email']);
            $pass = htmlentities($_POST['pass']);

            if(strpos($email,'@') === false)
            {
    
                $_SESSION['error'] = "Email must have at-sign (@)";
                header("Location: login.php");
                return;
            }
            else
            {
                $hash_check = hash('md5', $salt.$pass);    // for the security reasons we create hash which consist of salt and the password entered by the user
                if($hash_check == $stored_hash)
                {
                    error_log("Login Success ". $email);

                    $_SESSION['name'] = $email;
                    header("Location: view.php");
                    return;
                }
                else
                {
               
                    error_log("Login fail due to wrogn password:  " . $pass );
    
                    $_SESSION['error'] = "Incorrect password";
                    header("Location: login.php");
                    return;
                }
            }
        }
    }
?>

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
   
        <h1>Please Log In</h1>

        <?php
                if ( isset($_SESSION['error']) ) 
                {
                    echo(  '<p style="color: red;" class="col-sm-10 col-sm-offset-2">'. htmlentities($_SESSION['error']). "</p> \n"  );
                    unset($_SESSION['error']);
                }
        ?>

        <form method= "POST">
            
            <div class="form-group row">
                <label for="inputEmail" class="col-sm-2 col-form-label">User Name</label>
                <div class="col-sm-4">
                  <input type="text" name="email"  class="form-control" id="email">
                </div>
            </div>
  
            
            <div class="form-group row">
              <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
              <div class="col-sm-4">
                <input type="password"  name="pass"  class="form-control" id="Password">
              </div>
            </div>

            <div>
                <button type="submit" name= "login_btn" class="btn btn-outline-primary">Log In</button>
                <button type="submit" name= "cancel_btn" class="btn btn-outline-primary">Cancel</button>
            </div>
        
        </form>

        <p>
            For a password hint, view source and find a password hint
            in the HTML comments.
        </p>

       
  </body>
</html>