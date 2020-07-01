<?php

require_once'myvalues.php';

$con = mysqli_connect($host,$user,$pass,$db);
if ($con){
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$phone = $_POST['phone']."";
		
		$resp = array();
		
		$query = "select * from pdfs where user = '$phone' and status = 'public';";
		$result = mysqli_query($con,$query);
		while ($row = mysqli_fetch_array($result)){
			$temp = array();
			$temp['ImageUrl'] = $row[5];
			$temp['title'] = $row[3];
			$temp['episode'] = $row[4];
			$temp['pdfUrl'] = $row[6];
			
			$mypdf = $row[6];
			
			$counter = 0;
			
			$queryViews = "select * from pdfviews where user = '$phone' and pdfUrl='$mypdf';";
			$resultViews = mysqli_query($con,$queryViews);
			while ($rowViews = mysqli_fetch_array($resultViews)){
				$counter++;
			}
			
			$temp['views'] = $counter."";                                    
			
			array_push($resp,$temp);
		}
		
		echo json_encode($resp);
		
	}
}

?>