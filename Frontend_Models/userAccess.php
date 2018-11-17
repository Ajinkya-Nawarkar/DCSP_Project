<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>User Page</title>
    </head>
    <body>
        <h1>User Page</h1>
        <?php

            // start the session
            session_start();

            if (isset($_SESSION['currentUser']) && ($_SESSION['currentUser'] == 'user'))
            {
                echo "<p>Welcome Back User!</p>";
                echo "<p>Placeholder for User content</p>";
                echo "<p><a href='logout_page.php'>Log out</a></p>";
            }
            else
            {
                echo "<p>There is not a user logged in!</p>";
                echo "<p><a href='login_page.php'>Log in</a> to website.</p>";
            }
              
        ?>
    </body>
</html>
