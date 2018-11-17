<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Administrator Page</title>
    </head>
    <body>
        <h1>Administrator Page</h1>
        <?php
            // start the session
            session_start();

            if (isset($_SESSION['currentUser']) && ($_SESSION['currentUser'] == 'admin'))
            {
                echo "<p>Welcome Back Admin!</p>";
                echo "<p>Placeholder for Admin content</p>";
                echo "<p><a href='logout_page.php'>Log out</a></p>";
            }
            else
            {
                echo "<p>There is not an admin logged in!</p>";
                echo "<p><a href='login_page.php'>Log in</a> to website.</p>";
            }
            
            
        ?>
    </body>
</html>