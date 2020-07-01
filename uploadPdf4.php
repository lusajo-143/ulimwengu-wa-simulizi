<?php

require_once'myvalues.php';

$con = mysqli_connect("192.168.43.43","techdealer","techdeale","test");

if ($con) {
  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST["name"]) && isset($_FILES["pdf"]["name"])) {
      $name = $_POST['name'];
      $infomation = pathinfo($_FILES['pdf']['name']);
      $extension = $infomation['extension'];

      $folder = "uws/pdf/".$name.".pdf";
      $url = "http://192.168.43.43/".$folder;

      if (move_uploaded_file($_FILES['pdf']['tmp_name'],"pdf/".$name.".pdf")) {
        // code...
        $query = "insert into pdf values(null,'$name','$url');";
        if ($result = mysqli_query($con,$query)) {
          $resp = array('response' => 'done' );
        }
      }


    }
  }

}

 ?>
