# DCSP_Project

## phpMyAdmin Database Account Details
*Username* : cu81

*New Password* :maroongaming

## [Website in action tracking master](http://pluto.cse.msstate.edu/~an839/DCSP/link3_DCSP/DCSP_Project/) 
##### You would need access to Mississippi State University's pluto server to view this website. 

##### CronTab setting: * * * * * ( sleep 30; /path/to/cron.sh)

## Directory Structure: 
* index.php     - main file which implements and makes calls to all other php files and functions
* cron.sh       - a bash script which reflects changes in github repo on Pluto every minute for a given branch
* Frontend_Models      - Includes all the required php files needed for the frontend
* Backend_Models       - Includes all required php files for backend 
* Database             - Includes the databse API

        Frontend_Models/signup.php              - Enables the user to create an account
        Frontend_Models/login.php               - Enables user or Admin login 
        Frontend_Models/logout.php              - Enables the user to logout
        Frontend_Models/editAccount.php         - Enables user to edit Account details 
        Frontend_Models/viewCart.php            - Enables user to view and edit their cart 
        Frontend_Models/manageAccounts.php      - Enables admin to add or delte an admin
        Frontend_Models/createItem.php          - Enables admin to add a new product to the database
        Frontend_Models/editItem.php            - Enables admin to edit an existing product in the database
        Frontend_Models/checkout.php            - Just a dummy page for the checkout button

        Backend_Models/common.php               - Implements the common class for implementations of the shared functions
        Backend_Models/errException.php         - Implements the exception class for logging errors independently for different objects
        Backend_Models/user.php                 - Implements the user class for function implementations of a user
        Backend_Models/admin.php                - Implements the admin class for function implementations of a admin
        Backend_Models/item.php                 - Implements the item class for function implementations of items
        Backend_Models/editQuantity.php         - Implements the editQuantity class for edit and add item functionalities
        
        Database/dbAPI.php                      - Implements all functions needed for communication with the database
        
         
## Database Dummy Accounts: 

        *Users*
        user1           - password1
        user2           - password2
        kdd195          - kortni1234
        
        *Admins*
        an839           - ajinkya1234
        cu81            - chandler1234
        admin           - admin1
        admin2          - admin2
