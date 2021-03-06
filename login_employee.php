<?php
/* ---------------------------------------------------------------------------
 * filename    : login.php
 * author      : George Corser, gcorser@gmail.com
 * description : This program logs the user in by setting $_SESSION variables
 * ---------------------------------------------------------------------------
 */

// Start or resume session, and create: $_SESSION[] array
session_start(); 

require '../database/database.php';

if ( !empty($_POST)) { // if $_POST filled then process the form

	// initialize $_POST variables
	$username = $_POST['username']; // username is login
	$password = $_POST['password'];
	$passwordhash = MD5($password);
	// echo $password . " " . $passwordhash; exit();
	// robot 87b7cb79481f317bde90c116cf36084b
		
	// verify the username/password
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT * FROM car_Employees WHERE flag_confirmed = 1 AND login = ? AND password = ? LIMIT 1";
	$q = $pdo->prepare($sql);
	$q->execute(array($username,$passwordhash));
	$data = $q->fetch(PDO::FETCH_ASSOC);
	
	if($data) { // if successful login set session variables
		$_SESSION['session_id'] = $data['id']; //recognizing user
		$_SESSION['title'] = "employee"; //recognizing title
		Database::disconnect();
		header("Location: orders.php"); // can't do that, if we echoed sth before
		// javascript below is necessary for system to work on github
		echo "<script type='text/javascript'> document.location = 'orders.php'; </script>";
		exit();
	}
	else { // otherwise go to login error page
		Database::disconnect();
		header("Location: login_error.html");
		exit();
	}
} 
// if $_POST NOT filled then display login form, below.
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
	<link rel="icon" href="cardinal_logo.png" type="image/png" />
</head>

<body>
    <div class="container">

		<div class="span10 offset1">
		
			<div class="row">
				<img src="svsu_fr_logo.png" />
			</div>

			<div class="row">
				<h3>Auto Store Employee Login</h3>
			</div>

			<form class="form-horizontal" action="login_employee.php" method="post">
								  
				<div class="control-group">
					<label class="control-label">Login</label>
					<div class="controls">
						<input name="username" type="text"  placeholder="login" required> 
					</div>	
				</div> 
				
				<div class="control-group">
					<label class="control-label">Password</label>
					<div class="controls">
						<input name="password" type="password" placeholder="not a real one" required> 
					</div>	
				</div> 

				<div class="form-actions">
					<button type="submit" class="btn btn-success">Sign in</button>
				</div>
				
				<br />

				<footer>
					<small>&copy; Copyright 2020, Beata Hejno
					</small>
				</footer>
				
			</form>


		</div> <!-- end div: class="span10 offset1" -->
				
    </div> <!-- end div: class="container" -->

  </body>
  
</html>