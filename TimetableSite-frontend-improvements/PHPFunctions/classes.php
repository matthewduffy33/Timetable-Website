<?php
include '../Databases/connection.php'; 
include 'formCreation.php'; 
include 'formRetrieval.php'; 
include 'timetableCreation.php'; 

$course = $_REQUEST["Course"];
$year = $_REQUEST["Year"];

echo $course. $year;

$conn = DBConnection();

$sql= "SELECT ClassID FROM CourseYears, CourseSubjects WHERE CourseYears.YearID=CourseSubjects.YearID AND CourseYears.Year='".$year."' AND CourseYears.CourseName='".$course."'";
$rows = mysqli_query($conn, $sql);

$classes=array();

while($row = mysqli_fetch_assoc($rows)) {
    $classes[]=$row["ClassID"];
}


if(isset($_COOKIE["electiveID"])){
    $classes[]=$_COOKIE["electiveID"];
}

$colours = colourSelector($classes);



formCreator($colours, $classes, 1)

?>

