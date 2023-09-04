<?php
include 'admin.php';

$course= $_POST["course"];     


$conn = DBConnection();

$sql= "DELETE FROM CourseYears WHERE CourseName='".$course."'";
mysqli_query($conn, $sql);

$sql= "DELETE FROM Courses WHERE CourseName='".$course."'";
mysqli_query($conn, $sql);

?>



<head>
  
</head>

<body>
Class has been deleted
<button onclick="location.href='courses.php'" type="button">Ok</button>

</body>