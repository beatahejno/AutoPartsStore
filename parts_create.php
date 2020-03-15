<?php 
require 'session_management.php';
manage('employee'); //only employees can view
	require '../database/database.php';

	if ( !empty($_POST) ) {
		// keep track validation errors
		$nameError = null;
		$typeError = null;
		$priceError = null;
		$quantity_instoreError = null;
		
		// keep track post values
		$name = $_POST['name'];
		$type = $_POST['type'];
		$price = $_POST['price'];
		$quantity_instore = $_POST['quantity_instore'];
		
		// valiname input
		$valid = true;
		if (empty($name)) {
			$nameError = 'Please enter name';
			$valid = false;
		}
		
		if (empty($type)) {
			$typeError = 'Please enter type';
			$valid = false;
		}
		
		if (empty($price) || !is_numeric ($price)) {
			$priceError = 'Please enter correct price';
			$valid = false;
		} 
		
		if (empty($quantity_instore || !is_numeric($quantity_instore))) {
			$quantity_instoreError = 'Please enter correct quantity instore';
			$valid = false;
		}
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO car_Parts (name, type, price, quantity_instore) values(?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($name,$type, $price, $quantity_instore));
			Database::disconnect();
			header("Location: parts.php");
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
		    			<h3>Add a Part</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="parts_create.php" method="post">
					  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
					    <label class="control-label">Name</label>
					    <div class="controls">
					      	<input name="name" type="text" value="<?php echo !empty($name)?$name:'';?>">
					      	<?php if (!empty($nameError)): ?>
					      		<span class="help-inline"><?php echo $nameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($typeError)?'error':'';?>">
					    <label class="control-label">Type</label>
					    <div class="controls">
					      	<input name="type" type="text" value="<?php echo !empty($type)?$type:'';?>">
					      	<?php if (!empty($typeError)): ?>
					      		<span class="help-inline"><?php echo $typeError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($priceError)?'error':'';?>">
					    <label class="control-label">Price</label>
					    <div class="controls">
					      	<input name="price" type="number"  value="<?php echo !empty($price)?$price:'';?>">
					      	<?php if (!empty($priceError)): ?>
					      		<span class="help-inline"><?php echo $priceError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($quantity_instoreError)?'error':'';?>">
					    <label class="control-label">Quantity Instore</label>
					    <div class="controls">
					      	<input name="quantity_instore" type="number" value="<?php echo !empty($quantity_instore)?$quantity_instore:'';?>">
					      	<?php if (!empty($quantity_instoreError)): ?>
					      		<span class="help-inline"><?php echo $quantity_instoreError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="parts.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>