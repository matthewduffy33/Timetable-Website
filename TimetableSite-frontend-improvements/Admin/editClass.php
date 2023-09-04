<?php
include 'admin.php';

$id= $_POST["id"];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "timetable";
$conn = mysqli_connect($servername, $username, $password,$dbname);

$sql= "SELECT ClassName, LecturerName FROM Classes WHERE ClassID='".$id."'";
$class = mysqli_query($conn, $sql);
$class=mysqli_fetch_assoc($class);
$name= $class["ClassName"];
$lecturer= $class["LecturerName"];      

?>



<head>
  
</head>

<body>

<form method="post" action="classConfirmEdit.php">
    <input type='hidden' name='originalId' value='<?php echo $id;?>'/>

    Id: <input type="text" name="id" value="<?php echo $id;?>">

    Name: <input type="text" name="name" value="<?php echo $name;?>">

    Lecturer(s) Name: <input type="text" name="lecturer" value="<?php echo $lecturer;?>">


    <input type="submit" value="Edit class" />
</form>

</body>
