<?php
include 'admin.php';

$id= $_POST["id"];
$ogId=$_POST["originalId"];
$name= $_POST["name"];
$lecturer= $_POST["lecturer"];      

$conn = DBConnection();

if($ogId!=$id){
    $sql= "INSERT INTO Classes VALUES ('".$id."', '".$name."', '".$lecturer."')";
    mysqli_query($conn, $sql);

    $sql= "UPDATE Type SET ClassID='".$id."' WHERE ClassID='".$ogId."'";
    mysqli_query($conn, $sql);

    $sql= "UPDATE CourseSubjects SET ClassID='".$id."' WHERE ClassID='".$ogId."'";
    mysqli_query($conn, $sql);

    $sql= "DELETE FROM Classes WHERE ClassID='".$ogId."'";
    mysqli_query($conn, $sql);

}else{
    $sql= "UPDATE Classes SET ClassID='".$id."', ClassName='".$name."', LecturerName='".$lecturer."' WHERE ClassID='".$id."'";
    mysqli_query($conn, $sql);

}




?>



<head>
  
</head>

<body>
Class has been edited
<button onclick="location.href='classes.php'" type="button">Ok</button>

</body>
