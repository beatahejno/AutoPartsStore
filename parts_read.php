<?php 
	require 'session_management.php';
	require '../database/database.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: parts.php");
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM car_Parts where id = ?";
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
		    			<h3>Part Details</h3>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">Name</label>
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
						     	<?php echo $data['price'];?>
						    </label>
					    </div>
					  </div>
					  <?php //hiding stuff from customer
					if($title=="employee") echo	'  <div class="control-group">';
					if($title=="employee") echo	'    <label class="control-label">Quantity Instore</label>';
					if($title=="employee") echo	'    <div class="controls">';
					if($title=="employee") echo	'      	<label class="checkbox">';
					if($title=="employee") echo		     	$data['quantity_instore'];
					if($title=="employee") echo	'	    </label>';
					if($title=="employee") echo	'    </div>';
					if($title=="employee") echo	'  </div>';
					?>
					    <div class="form-actions">
						  <a class="btn" href="parts.php">Back</a>
					    </div>
					
					 
					</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>