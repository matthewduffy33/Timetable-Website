<?php
include 'admin.php';
include '../header.php';

$conn = DBConnection();

$course=$_POST["course"];

if(isset($_POST["remove"])){
    $sql="DELETE FROM CourseSubjects WHERE YearID=".$_POST["year"]." AND ClassID='".$_POST["classID"]."'";
    mysqli_query($conn, $sql);
}else if(isset($_POST["add"])){
    $sql="SELECT YearID FROM CourseYears WHERE CourseName='".$course."' AND Year=".$_POST["year"];
    $classes = mysqli_query($conn, $sql);

    $class = mysqli_fetch_assoc($classes);

    $yearID=$class["YearID"];

    $sql="INSERT INTO CourseSubjects VALUES('".$yearID."', '".$_POST["newClass"]."')";
    mysqli_query($conn, $sql);
}

$sql ="SELECT Year FROM CourseYears WHERE CourseName='".$course."'";

$years = mysqli_query($conn, $sql);

while($year = mysqli_fetch_assoc($years)) {
    echo $year["Year"]. "<br><br>";

    $sql ="SELECT * FROM CourseYears, CourseSubjects WHERE CourseYears.YearID= CourseSubjects.YearID AND CourseName='".$course."' AND Year ='".$year["Year"]."'";

    $classes = mysqli_query($conn, $sql);

    while($class = mysqli_fetch_assoc($classes)) {
        echo $class["ClassID"].
        "<form method='post' action=''>
            <input type='hidden' name='classID' value='".$class["ClassID"]."'/>
            <input type='hidden' name='year' value='".$year["Year"]."'/>
            <input type='hidden' name='course' value='".$course."'/>
            <input type='hidden' name='remove' value='".True."'/>
            <input type='submit' value='Delete course' />
        </form>";

    }

    echo "<form id=\"addClass".$year["Year"]."\"style=\"display:none;\" method=\"post\" action=''>
            <input type='hidden' name='add' value='True'/>
            <input type='hidden' name='year' value='".$year["Year"]."'/>
            <input type='hidden' name='course' value='".$course."'/>
            Class: ";
            echo "<select name=\"newClass\" >";
    
            $sql ="SELECT ClassID, ClassName 
            FROM Classes 
            WHERE ClassID NOT IN(
                                SELECT ClassID 
                                FROM CourseYears, CourseSubjects 
                                WHERE CourseYears.YearID= CourseSubjects.YearID AND CourseName='".$course."' AND Year ='".$year["Year"]."')";

            $classes = mysqli_query($conn, $sql);

            while($class = mysqli_fetch_assoc($classes)) {
                echo"<option value=\"".$class["ClassID"]."\">".$class["ClassID"]."</option>";
            }
    
            echo "</select>
            <input type=\"submit\" value=\"Add\" />
        </form>
        <button onclick=\"showEdit('addClass".$year["Year"]."')\">Add</button>
        <br> "; 

}

function classSelect($conn, $course, $year){
    echo "<select name=\"newClass\" >";
    
    $sql ="SELECT ClassID, ClassName 
    FROM Classes 
    WHERE ClassID NOT IN(
                        SELECT ClassID 
                        FROM CourseYears, CourseSubjects 
                        WHERE CourseYears.YearID= CourseSubjects.YearID AND CourseName='".$course."' AND Year ='".$year."')";

    $classes = mysqli_query($conn, $sql);

    while($class = mysqli_fetch_assoc($classes)) {
        echo"<option value=\"".$class["ClassID"]."\">".$class["ClassID"]."</option>";
    }
    
    echo "</select>";
}
?>


