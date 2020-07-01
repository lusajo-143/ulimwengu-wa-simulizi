<?php

require_once'myvalues.php';
$con = mysqli_connect($host,$user,$pass,$db);
if($con){
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$title = $_POST['title'];
		
		$query = "select * from videos where title like '%$title%';";
		$result = mysqli_query($con,$query);
		$resp = array();
		while ($row = mysqli_fetch_array($result)){
			$temp = array();
			$temp['id'] = $row[2];
			$temp['phone'] = $row[1];
			$temp['title'] = $row[3];
			$phone = $row[1];
			//getting profile picture
			$queryprof = "select * from users where phone='$phone';";
			$resultprof = mysqli_query($con,$queryprof);
			if ($rowprof = mysqli_fetch_array($resultprof)){
				$temp['prof'] = $rowprof[3];
			}
			
			array_push($resp,$temp);
		}
		
		echo json_encode($resp);
	}
	
}


?>