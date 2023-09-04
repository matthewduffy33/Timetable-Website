<head>
    <link rel="stylesheet" href="adminStyle.css">
</head>

<?php
include '../Databases/connection.php';
function allClasses(){
    $conn = DBConnection();

    $sql= "SELECT * FROM Classes";
    $classes = mysqli_query($conn, $sql);

    while($class = mysqli_fetch_assoc($classes)) {
        echo "<div class='row'>";
            echo $class["ClassID"]
            ."<form id=\"code".$class["ClassID"]."\"style=\"display:none;\" method=\"post\" action=''>
                <input type='hidden' name='originalId' value='". $class["ClassID"]."'/>
                <input type='hidden' name='edit' value='True'/>
                ClassID: <input type=\"text\" name=\"ClassID\" value='".$class["ClassID"]."' />
                <input type=\"submit\" value=\"Edit a course\" />
            </form>
            <button onclick=\"showEdit('code".$class["ClassID"]."')\">edit</button>
            <br> ";
            
            echo $class["ClassName"]
            ."<form id=\"classname".$class["ClassName"]."\"style=\"display:none;\" method=\"post\" action=''>
                <input type='hidden' name='originalId' value='". $class["ClassID"]."'/>
                <input type='hidden' name='edit' value='True'/>
                Name: <input type=\"text\" name=\"name\" value='".$class["ClassName"]."' />
                <input type=\"submit\" value=\"Edit a course\" />
            </form>
            <button onclick=\"showEdit('classname".$class["ClassName"]."')\">edit</button>
            <br> "; 
            
            echo $class["LecturerName"]
            ."<form id=\"lecturer".$class["LecturerName"]."\"style=\"display:none;\" method=\"post\" action=''>
                <input type='hidden' name='originalId' value='". $class["ClassID"]."'/>
                <input type='hidden' name='edit' value='True'/>
                Lecturer(s) Name: <input type=\"text\" name=\"lecturer\" value='".$class["LecturerName"]."'>
                <input type=\"submit\" value=\"Edit a course\" />
            </form>
            <button onclick=\"showEdit('lecturer".$class["LecturerName"]."')\">edit</button>
            <br> ";

            

            echo "<form method='post' action='deleteClass.php'>
                    <input type='hidden' name='id' value='".$class["ClassID"]."'/>
                    <input type='submit' value='Delete class' />
                </form>
            ";

            echo "<form method='post' action='sessions.php'>
                    <input type='hidden' name='id' value='".$class["ClassID"]."'/>
                    <input type='submit' value='View Sessions' />
                </form>
            ";

        echo "</div>";
    }
}


function allCourses(){
    $conn = DBConnection();

    $sql= "SELECT * FROM Courses";
    $classes = mysqli_query($conn, $sql);

    while($class = mysqli_fetch_assoc($classes)) {
        echo "<div class='row'>";
            echo $class["CourseName"]
            ."<form id=\"course".$class["CourseName"]."\"style=\"display:none;\" method=\"post\" action=''>
                <input type='hidden' name='originalName' value='". $class["CourseName"]."'/>
                <input type='hidden' name='edit' value='True'/>
                Course Name: <input type=\"text\" name=\"CourseName\" value='".$class["CourseName"]."' />
                <input type=\"submit\" value=\"Edit a course\" />
            </form>
            <button onclick=\"showEdit('course".$class["CourseName"]."')\">edit</button>
            <br> ";
            
            
            
            
            
            echo $class["AmountOfYears"]
            ."<form id=\"year".$class["AmountOfYears"]."\"style=\"display:none;\" method=\"post\" action=''>
                <input type='hidden' name='originalName' value='". $class["CourseName"]."'/>
                <input type='hidden' name='edit' value='True'/>
                Amount of Years: <input type=\"number\" name=\"year\" min=\"1\" max=\"10\" value='".$class["AmountOfYears"]."'>
                <input type=\"submit\" value=\"Edit a course\" />
            </form>
            <button onclick=\"showEdit('year".$class["AmountOfYears"]."')\">edit</button>
            <br> "; 
            
            
            echo $class["PlacementYear"]
            ."<form id=\"placement".$class["PlacementYear"]."\"style=\"display:none;\" method=\"post\" action=''>
                <input type='hidden' name='originalName' value='". $class["CourseName"]."'/>
                <input type='hidden' name='edit' value='True'/>
                Placement Year: <input type=\"number\" name=\"placement\" min=\"1\" max=\"".$class["AmountOfYears"]."\" value='".$class["PlacementYear"]."'>
                <input type=\"submit\" value=\"Edit a course\" />
            </form>";
                

            if(!is_null($class["PlacementYear"])){
                echo"
                <button onclick=\"showEdit('placement".$class["PlacementYear"]."')\">edit</button>
                <form id=\"placement".$class["PlacementYear"]."\" method=\"post\" action=''>
                    <input type='hidden' name='originalName' value='". $class["CourseName"]."'/>
                    <input type='hidden' name='remove' value='True'/>
                    <input type=\"submit\" value=\"Remove Placement\" />
                </form>";

            }else{
                echo"
                <button onclick=\"showEdit('placement".$class["PlacementYear"]."')\">Add Placement</button>";
            }
            echo"<br> ";
            
            
            

            echo "<form method='post' action='deleteCourse.php'>
                    <input type='hidden' name='course' value='".$class["CourseName"]."'/>
                    <input type='submit' value='Delete course' />
                </form>
            ";

            echo "<form method='post' action='courseClasses.php'>
                    <input type='hidden' name='course' value='".$class["CourseName"]."'/>
                    <input type='submit' value='View Classes' />
                </form>
            ";

        echo "</div>";
    }
}




?>

<script>
    function showEdit(id){
        var x = document.getElementById(id);
        x.style.display = "block";
    }
</script>