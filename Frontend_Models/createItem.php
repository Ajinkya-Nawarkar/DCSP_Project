<?php session_start(); error_reporting(E_ALL); ini_set('display_errors', 1); ?>

<!DOCTYPE html>
<html lang='en'>
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
            #newItem{
                margin-top: 50px;
                margin-left: 30px;
            }
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
                margin-top: 160px;
                padding-bottom: 200px;
            }
            body{font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:14px;line-height:1.42857143;color:#333;background-color:#fff}

            input[type=text], input[type=password] {
                width: 25%;
                padding: 15px;
                margin: 5px 0 5px 0;
                display: inline-block;
                border: none;
                background: #f1f1f1;
            }

            input[type=text]:focus, input[type=password]:focus {
                background-color: #ddd;
                outline: none;
            }
        </style>
    </head>
    <body>
        <?php

            require_once(dirname(__DIR__)."/Backend_Models/Common.php");
            require_once(dirname(__DIR__)."/Database/dbAPI.php");
            require_once(dirname(__DIR__)."/Backend_Models/item.php");
            
            // Initialize the variables 
            $sku = "";
            $name = "";
            $platform = "";
            $type = "";
            $developer = "";
            $description = "";
            $priceUSD = "";
            $quantity = "";

            # Error message variables
            $priceErr = "";
            $quantityErr = "";
            $errFlg = False;
            
            // Preserve the username to show if only password is incorrect
            $username = isset($_POST['username']);
            
            # Check if submission has been made
            if (!empty($_POST)) 
            {
              if (isset($_POST['sku'])) 
              {
                $sku = $_POST['sku'];
              } 

              if (isset($_POST['name'])) 
              {
                $name = $_POST['name'];
              }

              if (isset($_POST['platform'])) 
              {
                $platform = $_POST['platform'];
              } 

              if (isset($_POST['type'])) 
              {
                $type = $_POST['type'];
              }

              if (isset($_POST['developer'])) 
              {
                $developer = $_POST['developer'];
              }

              if (isset($_POST['description'])) 
              {
                $description = $_POST['description'];
              }

              if (isset($_POST['priceUSD'])) 
              {
                $priceUSD = $_POST['priceUSD'];
                if (!is_float($priceUSD) or $priceUSD <= 0) 
                {
                  $priceErr = "Price must be positive float and greater than or equal to 1";
                  $errFlg = True;
                } 
              } 

              if (isset($_POST['quantity'])) 
              {
                $quantity = $_POST['quantity'];
                if (!is_numeric($quantity) or $quantity <= 0) 
                {
                  $quantityErr = "Quantity must be positive integer and greater than or equal to 1";
                  $errFlg = True;
                }
              }
            }
            else {
              # While no error occurs, you still don't want to run the item entry to the database before a submission is made and redirect to index.php
              $errFlg = True;
            }    

            if (!$errFlg) 
            {
                # ADD ITEM TO DATABASE HERE
                $item = new Item($sku, $name, $platform, $type, $developer, $description, $priceUSD, $quantity);
                $item->addItemToDB();
                redirectUser();
            }       
        ?>

    <div class="w3-top">
        <div class="w3-bar w3-theme-d2 w3-left-align">

            <a href="#" class="w3-bar-item w3-button w3-teal"><i class="fa fa-home w3-margin-right"></i>Maroon Gamer</a>
            
            <a href="../index.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Home</a>

            <a href='manageAccounts.php' class='w3-bar-item w3-button w3-hide-small w3-hover-white'>Manage Accounts</a>

            <a href='logout.php' class='w3-bar-item w3-button w3-hide-small w3-right w3-teal' title='Logout'><i class='fa fa-sign-in' aria-hidden='true'></i> Logout</a>
        </div>
    </div>
        
	<div align="left" id="newItem">
    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div class="login-box col-md-12">
                    <form id="login-form" class="form" action="createItem.php" method="post">
                        <h2 class="text-center text-info"><b>Add an Item to a database</b></h2>
                        <p class="text-center text-info" style="margin-top: 5px"><b>Please fill in the details of the new product</b></p>
                        
                        <div class="form-group" style="margin-top: 30px">
                            <!-- ><label for="sku" class="text-info" style="margin-right: 10px;"><b>#SKU:</b></label><!-->
                            <input type="text" name="sku" id="sku" class="form-control" placeholder="#SKU" style="width: 235px;" required value="<?php echo $sku; ?>">
                        </div>
                        
                        <div class="form-group" style="margin-top: 30px">
                            <!-- ><label for="sku" class="text-info" style="margin-right: 10px;"><b>#SKU:</b></label><!-->
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name" style="width: 235px;" required value="<?php echo $name; ?>">
                        </div>                  

                        <div class="form-group" style="margin-top: 30px">
                            <!-- ><label for="sku" class="text-info" style="margin-right: 10px;"><b>#SKU:</b></label><!-->
                            <input type="text" name="platform" id="platform" class="form-control" placeholder="Platform" style="width: 235px;" required value="<?php echo $platform; ?>">
                        </div>

                        <div class="form-group" style="margin-top: 30px">
                            <!-- ><label for="sku" class="text-info" style="margin-right: 10px;"><b>#SKU:</b></label><!-->
                            <input type="text" name="type" id="type" class="form-control" placeholder="Type" style="width: 235px;" required value="<?php echo $type; ?>">
                        </div>

                        <div class="form-group" style="margin-top: 30px">
                            <!-- ><label for="sku" class="text-info" style="margin-right: 10px;"><b>#SKU:</b></label><!-->
                            <input type="text" name="developer" id="developer" class="form-control" placeholder="Developer" style="width: 235px;" required value="<?php echo $developer; ?>">
                        </div>

                        <div class="form-group" style="margin-top: 30px">
                            <!-- ><label for="sku" class="text-info" style="margin-right: 10px;"><b>#SKU:</b></label><!-->
                            <input type="text" name="description" id="description" class="form-control" placeholder="Description of the product" style="width: 235px;" required value="<?php echo $description; ?>">
                        </div>

                        <div class="form-group" style="margin-top: 30px">
                            <!-- ><label for="sku" class="text-info" style="margin-right: 10px;"><b>#SKU:</b></label><!-->
                            <input type="text" name="priceUSD" id="priceUSD" class="form-control" placeholder="Price in USD" style="width: 235px;" required value="<?php echo $priceUSD; ?>">
                        </div>

                        <?php
                            if ($priceErr)
                            {
                                echo "<p style='color: red'>";
                                echo "<span class='error'>";
                                echo $priceErr; 
                                echo "</span><br></p>";
                            }
                        ?>

                        <div class="form-group" style="margin-top: 30px">
                            <!-- ><label for="sku" class="text-info" style="margin-right: 10px;"><b>#SKU:</b></label><!-->
                            <input type="text" name="quantity" id="quantity" class="form-control" placeholder="Quantity available" style="width: 235px;" required value="<?php echo $quantity; ?>">
                        </div>
						
                        <?php
                            if ($quantityErr)
                            {
                                echo "<p style='color: red'>";
                                echo "<span class='error'>";
                                echo $quantityErr; 
                                echo "</span><br></p>";
                            }
                        ?>
                        
                        <div class="form-group-submit">
                            <input style="background-color: #4CAF50; color: white" type="submit" value="Add Item">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
        
<footer class="w3-container w3-padding-32 w3-theme-d1 w3-center">
    <h4>Maroon Gaming Co. @ 2018</h4>
</footer>

    </body>
</html>

<?php
    // redirect user to index.php
    function redirectUser()
    {
        header('Location: ../index.php');
        exit();
    }

    //helper functions to sanitize user entries
    function mysql_entities_fix_string($connection, $string)
    {
      return htmlentities(mysql_fix_string($connection, $string));
    }
    
    function mysql_fix_string($connection, $string)
    {
      if (get_magic_quotes_gpc()) $string = stripslashes($string);
      return $connection->real_escape_string($string);
    }

?>
