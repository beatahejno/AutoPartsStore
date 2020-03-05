<?php
require 'session_management.php';
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
	
			<?php //hiding stuff from customer
    		echo '<div class="row">';
			echo	'<button onclick="location.href = ' . "'orders.php'" . ';" id="btn_orders" class="float-left submit-button" >Orders</button>';
			if($title=="employee") echo	'<button onclick="location.href = ' . "'customers.php'" . ';" id="btn_customers" class="float-left submit-button" >Customers</button>';
			if($title=="employee") echo	'<button onclick="location.href = ' . "'employees.php'" . ';" id="btn_employees" class="float-left submit-button" >Employees</button>';
			echo	'<h3>Parts</h3>';
    		echo '</div>';
			?>
			
			<div class="row">
				<?php //customers can't create parts
				if($title=="employee") echo '<p>';
				if($title=="employee") echo 	'<a href="parts_create.php" class="btn btn-success">Create</a>';
				if($title=="employee") echo '</p>';
				?>
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Name</th>
		                  <th>Type</th>
		                  <th>Price</th>
		                  <th>Quantity Instore</th>
						  <th>Actions</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   require '../database/database.php'; 
					   $pdo = Database::connect();
					   $sql = 'SELECT * FROM car_Parts ORDER BY id DESC';
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['name'] . '</td>';
								echo '<td>'. $row['type'] . '</td>';
							   	echo '<td>'. $row['price'] . '</td>';
							   	echo '<td>'. $row['quantity_instore'] . '</td>';
							   	echo '<td width=250>';
							   	echo '<a class="btn" href="parts_read.php?id='.$row['id'].'">Read</a>';
							   	if($title=="employee") echo '&nbsp;';
							   	if($title=="employee") echo '<a class="btn btn-success" href="parts_update.php?id='.$row['id'].'">Update</a>';
							   	if($title=="employee") echo '&nbsp;';
							   	if($title=="employee") echo '<a class="btn btn-danger" href="parts_delete.php?id='.$row['id'].'">Delete</a>';
							   	echo '</td>';
							   	echo '</tr>';
					   }
					   Database::disconnect();
					  ?>
				      </tbody>
	            </table>
    	</div>
    </div> <!-- /container -->
  </body>
</html>