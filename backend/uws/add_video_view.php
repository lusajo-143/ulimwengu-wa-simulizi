<?php

require_once'myvalues.php';
$con = mysqli_connect($host,$user,$pass,$db);
if($con){
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$id = $_POST['id'];
		$owner = $_POST['owner']."";
		$viewer = $_POST['viewer']."";
		
		if ($owner != $viewer){
			//check
			$queryc = "select * from videoviews where viewer = '$viewer';";
			$resultc = mysqli_query($con,$queryc);
			if (mysqli_fetch_array($resultc)){
				
			}else {
				$query = "insert into videoviews values (null,'$viewer','$id');";
				if (mysqli_query($con,$query)){
					
				}
			}
		}
	}
}

?>