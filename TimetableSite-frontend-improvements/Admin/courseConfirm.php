<?php
include 'admin.php';

$id= $_POST["id"];
$name= $_POST["name"];
$lecturer= $_POST["lecturer"];      


$conn = DBConnection();

$sql= "INSERT INTO Classes VALUES ('".$id."', '".$name."', '".$lecturer."')";
mysqli_query($conn, $sql);

?>



<head>
  
</head>

<body>
Class has been added
<button onclick="location.href='courses.php'" type="button">Ok</button>

</body>
