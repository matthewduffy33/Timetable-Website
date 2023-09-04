
<?php
include '../Databases/connection.php';


$course = $_REQUEST["Course"];

$conn = DBConnection();

$sql= "SELECT Year FROM CourseYears WHERE CourseName='".$course."'";
$class = mysqli_query($conn, $sql);

echo "<select id='year' name='year'>";
    while($row = mysqli_fetch_assoc($class)) {
        echo "<option value='".$row["Year"]."' >". $row["Year"] ." </option>";
        
    }
echo "</select>";

?>