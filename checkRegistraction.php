<?php

require_once'myvalues.php';
$con = mysqli_connect($host,$user,$pass,$db);
if($con){
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$phone = $_POST['phone'];
		
		$query = "select * from users where phone='$phone';";
		$result = mysqli_query($con,$query);
		if($row = mysqli_fetch_array($result)){
			
			$name = $row[1];
			$prof = $row[3];
			
			$resp = array("response" => "registered","username" => $name, "prof" => $prof);
			echo json_encode($resp);
		}else {
			$resp = array("response" => "not registered");
			echo json_encode($resp);
		}
		
	}
}

?>