<?php 
	require 'session_management.php';
	require '../database/database.php';

	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: parts.php");
	}
	
	if ( !empty($_POST)) {
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
		
		// validate input
		$valid = true;
		if (empty($name)) {
			$nameError = 'Please enter name';
			$valid = false;
		}
		
		if (empty($type)) {
			$typeError = 'Please enter type';
			$valid = false;
		}
		
		if (empty($price) || $price <= 0) {
			$priceError = 'Please enter price';
			$valid = false;
		} 
		
		if (empty($quantity_instore)) {
			$quantity_instoreError = 'Please enter a correct quantity';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE car_Parts SET name = ?, type = ?, price = ?, quantity_instore = ? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($name,$type, $price, $quantity_instore, $id));
			Database::disconnect();
			header("Location: parts.php");
		}
		
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM car_Parts where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$name = $data['name'];
		$type = $data['type'];
		$price = $data['price'];
		$quantity_instore = $data['quantity_instore'];
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
		    			<h3>Update a Part</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="parts_update.php?id=<?php echo $id?>" method="post">
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
					      	<input name="price" type="number"  placeholder="price" value="<?php echo !empty($price)?$price:'';?>">
					      	<?php if (!empty($priceError)): ?>
					      		<span class="help-inline"><?php echo $priceError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($quantity_instoreError)?'error':'';?>">
					    <label class="control-label">Quantity instore</label>
					    <div class="controls">
					      	<input name="quantity_instore" type="number" placeholder="quantity_instore" value="<?php echo !empty($quantity_instore)?$quantity_instore:'';?>">
					      	<?php if (!empty($quantity_instoreError)): ?>
					      		<span class="help-inline"><?php echo $quantity_instoreError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="parts.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>