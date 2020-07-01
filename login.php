<?php

require_once'myvalues.php';
$con = mysqli_connect($host,$user,$pass,$db);
if($con){
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$username = $_POST['username'];
		$phone = $_POST['phone'];
		$prof = $_POST['prof'];
		
		
		$path = "profiles/".$username."_".$phone.".jpg";
		$url = "http://192.168.43.43/uws/".$path;
		
		//save img
		file_put_contents($path,base64_decode($prof));
		
		//saving to database		
		$query = "insert into users values (null,'$username','$phone','$url');";
		if(mysqli_query($con,$query)){
			$resp = array();
			$temp = array();
			$temp['prof'] = $url;
			array_push($resp,$temp);
			echo json_encode($resp);
		}
		
	}
}

?>