<?php

require_once'myvalues.php';
$con = mysqli_connect($host,$user,$pass,$db);
if($con){
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$phone = $_POST['uploader'];
		$pdfUrl = $_POST['pdfUrl'];
		$viewer = $_POST['viewer'];
		
		
		//checking if viewer is uploader
		if($phone != $viewer){
			//check if already viewed
			$query = "select * from pdfviews where viewer='$viewer' and pdfUrl='$pdfUrl';";
			$result = mysqli_query($con,$query);
			
			if($row = mysqli_fetch_array($result)){
				
			}else {
				//inserting new viewer
				//adding views
				$queryIns = "insert into pdfviews values (null,'$viewer','$phone','$pdfUrl');";
				if(mysqli_query($con,$queryIns)){
					
				}
				
			}
			
			
		}
		
		
	}
}

?>