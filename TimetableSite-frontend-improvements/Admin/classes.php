<?php
include 'admin.php';
include '../header.php';

$conn = DBConnection();


if(isset($_POST["edit"])){
    if(isset($_POST["ClassID"])){
        $ogId=$_POST["originalId"];
        $id=$_POST["ClassID"];

        $sql= "SELECT * FROM Classes WHERE ClassID='".$ogId."'";
        $classes = mysqli_query($conn, $sql);

        $class = mysqli_fetch_assoc($classes);

        $name=$class["ClassName"];
        $lecturer=$class["LecturerName"];

        $sql= "INSERT INTO Classes VALUES ('".$id."', '".$name."', '".$lecturer."')";
        mysqli_query($conn, $sql);
    
        $sql= "UPDATE Type SET ClassID='".$id."' WHERE ClassID='".$ogId."'";
        mysqli_query($conn, $sql);
    
        $sql= "UPDATE CourseSubjects SET ClassID='".$id."' WHERE ClassID='".$ogId."'";
        mysqli_query($conn, $sql);
    
        $sql= "DELETE FROM Classes WHERE ClassID='".$ogId."'";
        mysqli_query($conn, $sql);

    }else if(isset($_POST["name"])){
        $sql= "UPDATE Classes SET ClassName='".$_POST["name"]."' WHERE ClassID='".$_POST["originalId"]."'";
        mysqli_query($conn, $sql);
    }else{
        $sql= "UPDATE Classes SET LecturerName='".$_POST["lecturer"]."' WHERE ClassID='".$_POST["originalId"]."'";
        mysqli_query($conn, $sql);
    }
}


?>



<head>
  
</head>

<body>
<script src="modal.js"></script>

<div class="container">
    <?php allClasses(); ?>  
</div>

<form method="post" action="addClass.php">
    <input type='submit' value='Add a class' />
</form>

</body>


