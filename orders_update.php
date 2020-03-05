<?php 
	require 'session_management.php';
	require '../database/database.php';
	
	//check if cust -> if the cust_id matches the user_id

	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: orders.php");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$statusError = null;
		
		// keep track post values
		$status = $_POST['status'];
		
		// validate input
		$valid = true;
		if (empty($status)) {
			$statusError = 'Please enter status';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE car_Orders SET status = ? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($status, $id));
			Database::disconnect();
			header("Location: orders.php");
		}
		
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM car_Orders where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$status = $data['status'];
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
		    			<h3>Update an Order</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="orders_update.php?id=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($statusError)?'error':'';?>">
					    <label class="control-label">Status</label>
					    <div class="controls">
					      	<input name="status" type="text" value="<?php echo !empty($status)?$status:'';?>">
					      	<?php if (!empty($statusError)): ?>
					      		<span class="help-inline"><?php echo $statusError;?></span>
					      	<?php endif; ?>
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