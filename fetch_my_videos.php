<?php

require_once'myvalues.php';
$con = mysqli_connect($host,$user,$pass,$db);
if($con){
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		
		$phone = $_POST['phone']."";
		
		
		$query = "select * from videos where user = '$phone';";
		$result = mysqli_query($con,$query);
		$resp = array();
		while ($row = mysqli_fetch_array($result)){
			$temp = array();
			$temp['id'] = $row[2];
			$temp['title'] = $row[3];
			
			//getting views
			$id = $row[2];
			$queryV = "select * from videoviews where vidID = '$id';";
			$counter = 0;
			$resultV = mysqli_query($con,$queryV);
			while ($rowcounter = mysqli_fetch_array($resultV)){
				$counter++;
			}
			
			$temp['views'] = $counter."";
			array_push($resp,$temp);
		}
		echo json_encode($resp);
		
	}
	
}
?>