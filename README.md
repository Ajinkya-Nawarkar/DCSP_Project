# DCSP_Project

## phpMyAdmin Database Account Details
*Username* : cu81

*Password* : aDqhvAtAp4ny5JMr

## [Website in action LINK 1 tracking signup_front](http://pluto.cse.msstate.edu/~an839/DCSP/link1_DCSP/DCSP_Project/)
## [Website in action LINK 2 tracking index_front](http://pluto.cse.msstate.edu/~an839/DCSP/link2_DCSP/DCSP_Project/)
## [Website in action LINK 3 tracking master](http://pluto.cse.msstate.edu/~an839/DCSP/link3_DCSP/DCSP_Project/)

##### CronTab setting: * * * * * ( sleep 30; /path/to/cron.sh)

## Folder Structure: 
* index.php     - main file which implements and makes calls to all other php files and functions
* Frontend_Models      - Includes all the required php files needed for the frontend
* Backend_Models       - Includes all required php files for backend 

        Frontend_Models/design-top.php   - Implements the Design top for the homepage
        Frontend_Models/footer.php       - Implements the footer and access to all quick links for the user
        Frontend_Models/navigation.php   - Implements the navigation bar linking to inventory, login, logout, signup pages
        Frontend_Models/signup.php       - Enables the user to create an account
        Frontend_Models/logout.php       - Enables the user to logout while saving the current cookie session
        Frontend_Models/login.php        - Enables user or Admin login 
        Frontend_Models/userAccess.php   - Enables user functions 
        Frontend_Models/adminAccess.php  - Enables admin functions 

        Backend_Models/common.php               - Implements the common class for implementations of the shared functions
        Backend_Models/errException.php         - Implements the exception class for logging errors independently for different objects
        Backend_Models/user.php                 - Implements the user class for function implementations of a user
        Backend_Models/admin.php                - Implements the admin class for function implementations of a admin
        Backend_Models/item.php                 - Implements the item class for function implementations of items
         
## Database Dummy Accounts: 

        user1           - password1
        user2           - password2
        an839           - Qwerty123
        an8391          - qwerty123
        cu81            - Qwerty123
        admin           - admin1
        admin2          - admin2
