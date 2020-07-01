<?php

require_once'myvalues.php';
$con = mysqli_connect($host,$user,$pass,$db);
if($con){
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$phon = $_POST['phone'];
		$phone = $phon."";
		
		$query = "select * from pdfs where user='$phone' and status='private';";
		$result = mysqli_query($con,$query);
		$resp = array();
		while ($row = mysqli_fetch_array($result)){
			$temp = array();
			$temp['cover'] = $row[5];
			$temp['title'] = $row[3];
			$temp['ep'] = $row[4];
			$temp['pdfUrl'] = $row[6];
			
			array_push($resp,$temp);
		}
		
		echo json_encode($resp);
	}
}

?>