<?php 
require 'session_management.php';
manage('employee'); //only employees can view
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
    		
			<div class="row">
				<button onclick="location.href = 'orders.php';" id="myButton" class="float-left submit-button" >Orders</button>
    			<button onclick="location.href = 'parts.php';" id="myButton" class="float-left submit-button" >Parts</button>
				<button onclick="location.href = 'employees.php';" id="myButton" class="float-left submit-button" >Employees</button>
				<h3>Customers</h3>
    		</div>
			
			<?php 
			require 'logout_n_profile.php'
			?>
			
			<div class="row">
				
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>First Name</th>
		                  <th>Last Name</th>
		                  <th>Address</th>
		                  <th>Email Address</th>
		                  <th>Action</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   require '../database/database.php'; 
					   $pdo = Database::connect();
					   $sql = 'SELECT * FROM car_Customers ORDER BY id DESC';
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['fname'] . '</td>';
								echo '<td>'. $row['lname'] . '</td>';
							   	echo '<td>'. $row['address'] . '</td>';
							   	echo '<td>'. $row['email'] . '</td>';
							   	echo '<td width=250>';
							   	echo '<a class="btn" href="customers_read.php?id='.$row['id'].'">Read</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-danger" href="customers_delete.php?id='.$row['id'].'">Delete</a>';
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