<?php session_start(); error_reporting(E_ALL); ini_set('display_errors', 1); ?>
<!DOCTYPE html>
<html>
    <head>
        <link href="css.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <meta charset="UTF-8">
        <title>Maroon Gaming Co</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            .text-center{
            margin-top: -10px;
            }
            .form-group{
                margin-top: 5px;
                padding-bottom: 3px;
            }
            .form-group-submit{
                margin-top: 14px;
                padding-bottom: 2px;
            }
            footer{
                margin-top: 200px;
                padding-bottom: 200px;
            }
        </style>
    </head>

    <?php
        // destroy session
        session_unset();
        session_destroy();      
    ?> 
    <body>

    <div class="w3-top">
        <div class="w3-bar w3-theme-d2 w3-left-align">

            <a href="#" class="w3-bar-item w3-button w3-teal"><i class="fa fa-home w3-margin-right"></i>Maroon Gamer</a>
            <a href="../index.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Home</a>
        </div>
    </div>

        <h2 style="margin-left:20px; margin-top: 60px" class="text-center text-info"><b>Log Out</b></h2>
        <p style="margin-left:20px" class="text-center text-info" style="margin-top: 5px"><b>You are now logged out of the website.</b></p>
        
        <a style="margin-left:20px; margin-top: 10px; background-color: grey; color: white" href="login.php" class="w3-bar-item w3-button"> Log Back In</a>

        <footer class="w3-container w3-padding-32 w3-theme-d1 w3-center">
          <h4>Maroon Gaming Co. @ 2018</h4>
      </footer>

    </body>
</html>