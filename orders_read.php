<?php
require 'session_management.php';
manage('everyone'); //everyone can view

	require '../database/database.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: assignments.php");
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = 'SELECT *, o.id FROM car_Customers c, car_Parts p, car_Orders o WHERE c.id=o.car_cust_id AND p.id=o.car_part_id AND o.id = ?';
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
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
		    			<h3>Order information</h3>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">First Name</label>
					    <div class="controls">
						    <label class="checkbox">
						     	<?php echo $data['fname'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Last Name</label>
					    <div class="controls">
						    <label class="checkbox">
						     	<?php echo $data['lname'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Address</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['address'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Email Address</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['email'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Date Ordered</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['date_ordered'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Quantity Ordered</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['num_ordered'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Part Name</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['name'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Type</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['type'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Price</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo "$" . $data['price'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Status</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['status'];?>
						    </label>
					    </div>
					  </div>
					    
						<div class="form-actions">
						  <a class="btn" href="orders.php">Back</a>
					    </div>
					
					</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>