<?php
require 'session_management.php';
manage('everyone'); //everyone can view
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
    		
			<?php  //hiding stuff from the customer
			echo '<div class="row">';
			echo	'<button onclick="location.href = ' . "'parts.php'" . ';" id="btn_parts" class="float-left submit-button" >Parts</button>';
			if($title=="employee") echo	'<button onclick="location.href = ' . "'customers.php'" . ';" id="btn_customers" class="float-left submit-button" >Customers</button>';
			if($title=="employee") echo	'<button onclick="location.href = ' . "'employees.php'" . ';" id="btn_employees" class="float-left submit-button" >Employees</button>';
			echo	'<h3>Orders</h3>';
    		echo '</div>';
			?>
			
			<?php 
			require 'logout_n_profile.php'
			?>
			
			<div class="row">
				
				<?php
				if($title=="customer"){ //create button for customers only
					echo '<p>';
					echo '<a href="orders_create.php" class="btn btn-success">Create</a>';
					echo '</p>';
				}
				?>
				
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>ID</th>
		                  <th>Last Name</th>
		                  <th>Date Ordered</th>
		                  <th>Quantity Ordered</th>
						  <th>Part Name</th>
						  <th>Status</th>
						  <th>Actions</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   require '../database/database.php'; 
					   $pdo = Database::connect();
					   $sql = 'SELECT *, o.id FROM car_Customers c, car_Parts p, car_Orders o WHERE c.id=o.car_cust_id AND p.id=o.car_part_id';
					   if($title=="customer"){ //customers only see their records
						   $sql .= ' AND o.car_cust_id = ' . $user_id;
					   }
					   $q = $pdo->prepare($sql);
	 				   foreach ($pdo->query($sql) as $row) {
								echo '<tr>';
							   	echo '<td>'. $row['id'] . '</td>';
								echo '<td>'. $row['lname'] . '</td>';
							   	echo '<td>'. $row['date_ordered'] . '</td>';
							   	echo '<td>'. $row['num_ordered'] . '</td>';
								echo '<td>'. $row['name'] . '</td>';
								echo '<td>'. $row['status'] . '</td>';
							   	echo '<td width=250>';
							   	echo '<a class="btn" href="orders_read.php?id='.$row['id'].'">Details</a>';
								echo '<a class="btn" href="orders_update.php?id='.$row['id'].'">Update</a>';
								if($title=="employee") echo '<a class="btn" href="orders_delete.php?id='.$row['id'].'">Delete</a>';
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