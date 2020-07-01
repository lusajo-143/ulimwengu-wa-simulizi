<?php

require_once'myvalues.php';
$con = mysqli_connect($host,$user,$pass,$db);
if($con){
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$phone = $_POST['phone'];
		$id = $_POST['id'];
		$title = $_POST['title'];
		
		
		$checkid = "select * from videos where vidID = '$id';";
		$resultid = mysqli_query($con,$checkid);
		if($rowid = mysqli_fetch_array($resultid)){
			$resp = array("response" => "This video has already been uploaded");
			echo json_encode($resp);
		}else {
			//inserting to database
			$query = "insert into videos values (null,'$phone','$id','$title');";
			if(mysqli_query($con,$query)){
				$resp = array("response" => "Done uploading...");
				echo json_encode($resp);
			}
		}
	}
}

?>