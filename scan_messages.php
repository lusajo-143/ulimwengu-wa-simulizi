<?php

require_once'myvalues.php';
$con = mysqli_connect($host,$user,$pass,$db);

if($con){
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$phone = $_POST["phone"];
		
		$query = "select * from messages where receiver='$phone' and status='false';";
		$result = mysqli_query($con,$query);
		$resp = array();
		
		while($row = mysqli_fetch_array($result)){
			$temp = array();
			$temp["phone"] = $row[1];
			array_push($resp,$temp);
		}
		
		echo json_encode($resp);
	}
}

?>