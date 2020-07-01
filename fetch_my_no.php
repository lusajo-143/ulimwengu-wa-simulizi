<?php

require_once'myvalues.php';
$con = mysqli_connect($host,$user,$pass,$db);
if($con){
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$phone = $_POST['phone'];
		
		$queryPdf = "select * from pdfs where user='$phone';";
		$resultPdf = mysqli_query($con,$queryPdf);
		$counterPdf = 0;
		while ($row = mysqli_fetch_array($resultPdf)){
			$counterPdf++;
		}
		
		$queryVid = "select * from videos where user='$phone';";
		$resultVid = mysqli_query($con,$queryVid);
		$counterVid = 0;
		while ($row = mysqli_fetch_array($resultVid)){
			$counterVid++;
		}
		
		$resp = array("pdf" => $counterPdf."", "vid" => $counterVid."");
		echo json_encode($resp);
	}
}

?>