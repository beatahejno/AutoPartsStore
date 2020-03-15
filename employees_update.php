<?php 
require 'session_management.php';
manage('employee'); //only employees can view
	require '../database/database.php';
	
	//not using id, just user_id, bc noone except for the user can change their data
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$fnameError = null;
		$lnameError = null;
		$loginError = null;
		$passwordError = null;
		
		// keep track post values
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$login = $_POST['login'];
		$password = $_POST['password'];
		$passwordhash = MD5($password);
		
		// validate input
		$valid = true;
		if (empty($fname)) {
			$fnameError = 'Please enter first name';
			$valid = false;
		}
		
		if (empty($lname)) {
			$lnameError = 'Please enter last name';
			$valid = false;
		}
		
		if (empty($login)) {
			$loginError = 'Please enter login';
			$valid = false;
		}
		
		if (empty($password)) {
			$passwordError = 'Please enter password';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE car_Employees  set fname = ?, lname = ?, password =?, login = ? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($fname,$lname,$passwordhash,$login,$user_id));
			Database::disconnect();
			header("Location: employees.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM car_Employees where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($user_id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$fname = $data['fname'];
		$lname = $data['lname'];
		$login = $data['login'];
		$password = "";
		Database::disconnect();
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Update your information</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="customers_update.php" method="post">
					  <div class="control-group <?php echo !empty($fnameError)?'error':'';?>">
					    <label class="control-label">First Name</label>
					    <div class="controls">
					      	<input name="fname" type="text"  placeholder="First Name" value="<?php echo !empty($fname)?$fname:'';?>">
					      	<?php if (!empty($fnameError)): ?>
					      		<span class="help-inline"><?php echo $fnameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($lnameError)?'error':'';?>">
					    <label class="control-label">Last Name</label>
					    <div class="controls">
					      	<input name="lname" type="text"  placeholder="Last Name" value="<?php echo !empty($lname)?$lname:'';?>">
					      	<?php if (!empty($lnameError)): ?>
					      		<span class="help-inline"><?php echo $lnameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($loginError)?'error':'';?>">
					    <label class="control-label">Login</label>
					    <div class="controls">
					      	<input name="login" type="text" value="<?php echo !empty($login)?$login:'';?>">
					      	<?php if (!empty($loginError)): ?>
					      		<span class="help-inline"><?php echo $loginError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($passwordError)?'error':'';?>">
					    <label class="control-label">Password</label>
					    <div class="controls">
					      	<input name="password" type="password"  placeholder="new password" value="<?php echo !empty($password)?$password:'';?>">
					      	<?php if (!empty($passwordError)): ?>
					      		<span class="help-inline"><?php echo $passwordError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="orders.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>