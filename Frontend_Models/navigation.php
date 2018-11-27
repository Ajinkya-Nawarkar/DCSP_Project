<!DOCTYPE html>
<html>
<head>
	<title></title>
<style type="text/css">
ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #800000;
}

li {
    float: left;
}

li a {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

li a:hover {
    background-color: #111;
}
</style>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
</head>
		
		
		<div id="nav">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="browse.php">Browse</a></li>
				 <?php
				 if(isset($_SESSION['username']) && $_SESSION['type'] == 'user'){
					echo "Welcome user";
					echo"<a href=".'cart.php'.">View Cart/Checkout</a>";
					echo"<a href=".'logout.php'.">Logout</a>";
				 }
				 elseif(isset($_SESSION['username']) && $_SESSION['type'] == 'admin'){
					echo "Welcome Admin";
					echo"<a href=".'manageAcc.php'.">Manage Accounts</a>";
					echo"<a href=".'logout.php'.">Logout</a>";
					 
				 }
				else{
					echo "Welcome!";
					echo"<a href=".'login_page.php'.">Log In Page</a>";
				?>
				<div class="search-container">
					<form action="/browse.php">
						<input type="text" placeholder="Search.." name="search">
						<button type="submit" class="searchButton">
							<i class="fa fa-search"></i>
						</button>
				</div>
			</ul>
		</div><! -- nav -->
		
		<div class="content">