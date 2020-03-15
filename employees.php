<?php
require 'session_management.php';
manage('employee'); //only employees can view
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <script src="js/bootstrap.min.js"></script>
    </head>

    <body>
        <div class="container">

            <?php //no need to hide - only employee could get to this site
    		echo '<div class="row">';
			echo	'<button onclick="location.href = ' . "'orders.php'" . ';" id="btn_orders" class="float-left submit-button" >Orders</button>';
			echo	'<button onclick="location.href = ' . "'customers.php'" . ';" id="btn_customers" class="float-left submit-button" >Customers</button>';
			echo	'<button onclick="location.href = ' . "'parts.php'" . ';" id="btn_parts" class="float-left submit-button" >Parts</button>';
			echo	'<h3>Employees</h3>';
    		echo '</div>';
			?>
			
			<?php 
			require 'logout_n_profile.php'
			?>

                <div class="row">

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Login</th>
                                <th>New Employee?</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
					   require '../database/database.php'; 
					   $pdo = Database::connect();
					   $sql = 'SELECT * FROM car_Employees ORDER BY id DESC';
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['fname'] . '</td>';
								echo '<td>'. $row['lname'] . '</td>';
							   	echo '<td>'. $row['login'] . '</td>';
								echo '<td>'. ($row['flag_confirmed']==0 ?
									'<a class="btn btn-success" href="employees_accept.php?id='.$row['id'].'">Accept</a>' : "-") . '</td>';
							   	echo '<td width=250>';
							   	echo '<a class="btn btn-danger" href="employees_delete.php?id='.$row['id'].'">Delete</a>';
							   	echo '</td>';
							   	echo '</tr>';
					   }
					   Database::disconnect();
					  ?>
                        </tbody>
                    </table>

                </div>
        </div>
        <!-- /container -->
    </body>

    </html>