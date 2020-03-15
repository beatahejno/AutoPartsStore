<?php 
	session_start();
	if(!isset($_SESSION["session_id"]) || isset($_POST['logout'])){ // if "user" not set,
		exitapp();
	}
	$user_id = $_SESSION['session_id'];
	$title = $_SESSION['title'];

function manage($allowed){
	if($allowed == 'everyone'){
		//all's good
	}else if ($allowed != $_SESSION['title']){ //allowed is either customer or employee
		exitapp();
	}
}

function exitapp() {
	session_destroy();
	header('Location: login.php');   // go to login page
	exit;
}