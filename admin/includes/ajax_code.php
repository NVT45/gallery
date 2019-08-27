<?php 
require("init.php");
$user = new User();
if(isset($_POST['image_id'])){
	$user->ajax_save_user_image($_POST['image_id'],$_POST['user_id']);
}

if(isset($_POST['photo_id'])){
	Photo::display_sidebar_data($_POST['photo_id']);
}


 ?>