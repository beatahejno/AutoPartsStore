<?php 
   require 'session_management.php';
   manage('employee'); //only employees can view
   require '../database/database.php';
   
	//echo phpinfo(); 
   
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
		$errors = [];
		
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
			$sql = "UPDATE car_Parts SET name = ?, type = ?, price = ?, quantity_instore = ?";
			
			//array of allowed mimes, only jpeg or png
			$allowed = array ('image/pjpeg', 'image/jpeg', 'image/JPG', 'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png');
			
			if(isset($_POST['upload']) && $_FILES['picture']['size']>0 && in_array($_FILES['picture']['type'], $allowed)) {
				$fileName = $_FILES['picture']['name'];
				$tmpName  = $_FILES['picture']['tmp_name'];
				$fileSize = $_FILES['picture']['size'];
				$fileType = $_FILES['picture']['type']; //mime
				//$content = addslashes(file_get_contents($tmpName)); this was messing up the file
				$content = file_get_contents($tmpName);
				$sql .= ", file_name = ?, file_size = ?, file_type = ?, file_content = ? ";
			}
			$sql .= " WHERE id = ?";
			
			if(isset($_POST['upload']) && $_FILES['picture']['size']>0 && in_array($_FILES['picture']['type'], $allowed)) {
				$q = $pdo->prepare($sql);
				$q->bindParam(1, $name);
				$q->bindParam(2, $type);
				$q->bindParam(3, $price, PDO::PARAM_INT);
				$q->bindParam(4, $quantity_instore, PDO::PARAM_INT);
				$q->bindParam(5, $fileName);
				$q->bindParam(6, $fileSize, PDO::PARAM_INT);
				$q->bindParam(7, $fileType);
				$q->bindParam(8, $content, PDO::PARAM_LOB); 
				$q->bindParam(9, $id, PDO::PARAM_INT);
				$q->execute();
			}else{
				$q = $pdo->prepare($sql);
				$q->execute(array($name,$type, $price, $quantity_instore, $id));
			}
			
			Database::disconnect();
			
			if (!in_array($_FILES['picture']['type'], $allowed)) {
				$errors[0] = "This file extension is not allowed. Please upload a JPEG or PNG file";
			}
			
			if ($_FILES['picture']['size'] > 16000000) {
				$errors[1] = "This file is more than 2MB. Sorry, it has to be less than or equal to 2MB";
			}
			
			if(empty($errors) || $_FILES['picture']['size']==0) header("Location: parts.php");
		} else { //if _POST is empty
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM car_Parts where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC); //just the picture so it doesn't disappear
		$fileContent = $data['file_content'];
		$fileType = $data['file_type'];
		$fileSize = $data['file_size'];
		Database::disconnect();
		
		$errors = [];
	}
		
	} else { //if _POST is empty
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
		$fileContent = $data['file_content'];
		$fileType = $data['file_type'];
		$fileSize = $data['file_size'];
		Database::disconnect();
		
		$errors = [];
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
					
					<div class='control-group col-md-6'>
						<div class="controls ">
							<?php 
							if (!empty($fileContent) && $fileSize > 0) 
								echo '<img  height=5%; width=15%; src="data:' . $fileType . ';base64,' .base64_encode($fileContent). '" />'; 
							else 
								echo 'No photo on file.';
							?><!-- converts to base 64 due to the need to read the binary files code and display img -->
						</div>
					</div>
				
	    			<form class="form-horizontal" action="parts_update.php?id=<?php echo $id?>" method="post" enctype="multipart/form-data">
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
					  <div class="control-group <?php echo !empty($pictureError)?'error':'';?>">
					    <label class="control-label">Upload a picture of the part</label>
					    <div class="controls">
							<input type="hidden" name="MAX_FILE_SIZE" value="16000000">
							<input name="picture" type="file" id="picture" accept="image/*"> 
					    </div>
					  </div>
					  
						<div class="form-actions">
						  <input type="submit" name="upload" class="btn btn-success" id="upload">
						  <a class="btn" href="parts.php">Back</a>
						</div>
						
						<?php
						foreach($errors as $error){
							echo $error;
						}
						?>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>