<?php
include 'admin.php';

$id= $_POST["id"];
$name= $_POST["name"];
$lecturer= $_POST["lecturer"];      

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "timetable";
$conn = mysqli_connect($servername, $username, $password,$dbname);

$sql= "INSERT INTO Classes VALUES ('".$id."', '".$name."', '".$lecturer."')";
mysqli_query($conn, $sql);

?>



<head>
  
</head>

<body>
Class has been added
<button onclick="location.href='classes.php'" type="button">Ok</button>

</body>
