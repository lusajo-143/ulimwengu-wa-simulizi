<?php

require_once'myvalues.php';
$con = mysqli_connect($host,$user,$pass,$db);
if($con){
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$me = $_POST['me'];
		$other = $_POST['other'];
		
		//changing status
		$queryStatus = "update messages set status='true' where receiver='$me' and sender='$other' and status='false';";
		if(mysqli_query($con,$queryStatus)){
			
		}
		
		$query = "select * from messages where (sender='$me' and receiver='$other') or (sender='$other' and receiver='$me');";
		$result = mysqli_query($con,$query);
		$resp = array();
		while ($row = mysqli_fetch_array($result)){
			$temp = array();
			$temp['pdfUrl'] = $row[4];
			$temp['title'] = $row[7];
			$temp['ep'] = $row[8];
			$temp['message'] = $row[3];
			$temp['time'] = $row[5];
			$temp['status'] = $row[6];
			$temp['phone'] = $row[1]."";
			
			array_push($resp,$temp);
		}
		
		echo json_encode($resp);
		
	}
}

?>