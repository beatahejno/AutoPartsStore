<?php 
require 'session_management.php';
manage('everyone'); //everyone can view
	require '../database/database.php';

	if ( !empty($_POST) ) {
		// keep track validation errors
		$car_cust_idError = null;
		$car_part_idError = null;
		$num_orderedError = null;
		
		// keep track post values
		$car_part_id = $_POST['part'];
		$car_cust_id = $_POST['customer'];
		$date_ordered = date("Y-m-d",mktime(date('H')-6,date('i'),date('s'),date("m"),date("d"),date("Y"))); //eastern time
		$num_ordered = $_POST['num_ordered'];
		
		// validate input
		$valid = true;
		if (empty($car_cust_id)) {
			$car_cust_idError = 'Please choose a customer';
			$valid = false;
		}
		
		if (empty($car_part_id)) {
			$car_part_idError = 'Please choose a part';
			$valid = false;
		}
		
		if (empty($num_ordered) || $num_ordered <= 0) {
			$num_orderedError = 'Please choose a valid amount to order';
			$valid = false;
		}
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO car_Orders (car_cust_id, car_part_id, date_ordered, num_ordered, status) values(?, ?, ?, ?, 'ORDERED')";
			$q = $pdo->prepare($sql);
			$q->execute(array($car_cust_id,$car_part_id, $date_ordered, $num_ordered));
			Database::disconnect();
			header("Location: orders.php");
		}
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
		    			<h3>Place an Order</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="orders_create.php" method="post">
						<div class="control-group">
							<label class="control-label">Customer</label>
							<div class="controls">
								<?php
									$pdo = Database::connect();
									$sql = 'SELECT * FROM car_Customers ';
									if($title=="customer") $sql .= 'WHERE id=' . $user_id;
									$sql .= ' ORDER BY lname ASC, fname ASC';
									echo "<select class='form-control' name='customer' id='car_cust_id'>";
									foreach ($pdo->query($sql) as $row) {
										echo "<option value='" . $row['id'] . " '> " . $row['lname'] . ', ' .$row['fname'] . "</option>";
									}
									echo "</select>";
									Database::disconnect();
								?>
							</div>	<!-- end div: class="controls" -->
						</div> <!-- end div class="control-group" -->
			  
						<div class="control-group">
							<label class="control-label">Part</label>
							<div class="controls">
								<?php
									$pdo = Database::connect();
									$sql = 'SELECT * FROM car_Parts ORDER BY name ASC';
									echo "<select class='form-control' name='part' id='car_part_id'>";
									foreach ($pdo->query($sql) as $row) {
										echo "<option value='" . $row['id'] . " '> " . $row['name'] . 
										" ($" . $row['price'] . ")" . "</option>";
									}
										
									echo "</select>";
									Database::disconnect();
								?>
							</div>	<!-- end div: class="controls" -->
						</div> <!-- end div class="control-group" -->
						
						<div class="control-group <?php echo !empty($num_orderedError)?'error':'';?>">
					    <label class="control-label">Quantity</label>
					    <div class="controls">
					      	<input name="num_ordered" type="number"  placeholder="#" value="<?php echo !empty($num_ordered)?$num_ordered:'';?>">
					      	<?php if (!empty($num_orderedError)): ?>
					      		<span class="help-inline"><?php echo $num_orderedError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  
						<div class="form-actions">
							<button type="submit" class="btn btn-success">Confirm</button>
							<a class="btn" href="orders.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>