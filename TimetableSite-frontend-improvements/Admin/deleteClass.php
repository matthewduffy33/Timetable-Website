<?php
include 'admin.php';

$id= $_POST["id"];     


$conn = DBConnection();

$sql= "DELETE FROM Classes WHERE ClassID='".$id."'";
mysqli_query($conn, $sql);

$sql= "DELETE FROM CourseSubjects WHERE ClassID='".$id."'";
mysqli_query($conn, $sql);

$sql= "DELETE FROM Type WHERE ClassID='".$id."'";
mysqli_query($conn, $sql);

?>



<head>
  
</head>

<body>
Class has been deleted
<button onclick="location.href='classes.php'" type="button">Ok</button>

</body>