<?php
function arrayOfAdditional(){
    $conn = DBConnection();

    $sql= "SELECT Sessions.TypeID FROM Sessions, Type WHERE MultipleSessions=1 AND Sessions.TypeID=Type.TypeID";
    $classes = mysqli_query($conn, $sql);


    while($row = mysqli_fetch_assoc($classes)) {
        $types[]=$row["TypeID"];
    }
   

    for($i=0;$i<count($types);$i++){
        if(isset($_POST[$types[$i]])){
            $_SESSION[$types[$i]]= $_POST[$types[$i]];
        }

        $additional[] = $_SESSION[$types[$i]];
        
    }

    return $additional;
    
}


function arrayOfClasses(){
    $conn = DBConnection();

    $sql= "SELECT ClassID FROM CourseYears, CourseSubjects WHERE CourseYears.YearID=CourseSubjects.YearID AND Year='".$_SESSION["year"]."' AND CourseName='".$_SESSION["course"]."'";
    $classes = mysqli_query($conn, $sql);

    $array=array();
    
    while($row = mysqli_fetch_assoc($classes)) {
        $array[]=$row["ClassID"];
    }

    return $array;


}

function arrayOfSpecificClasses(){
    $conn = DBConnection();

    $course = $_COOKIE["CourseName"];
    $year = $_COOKIE["Year"];

    echo $course.$year;

    $sql= "SELECT ClassID FROM CourseYears, CourseSubjects WHERE CourseYears.YearID=CourseSubjects.YearID AND CourseName='".$course."' AND Year=".$year;
    $classes = mysqli_query($conn, $sql);

    $array=array();
    while($row = mysqli_fetch_assoc($classes)) {
        $array[]=$row["ClassID"];
    }

    return $array;


}

function arrayOfPickedClasses($classes){
    $array=[];

    for($i=0;$i<count($classes);$i++){

        if(!empty($_POST) && isset($_SESSION[$classes[$i]])) {
            unset($_SESSION[$classes[$i]]);
        }

        if(isset($_POST[$classes[$i]])){
            $_SESSION[$classes[$i]]= True;
        }
        
        if(isset($_SESSION[$classes[$i]])){
            $array[]=$classes[$i];
        }else if(isset($_COOKIE["electiveTrue"])&& $_COOKIE["electiveID"] == $classes[$i]){
            $array=$_COOKIE["electiveID"];
            setcookie("electiveTrue", "", time() - 3600, "/");
        }
    }

    return $array;

}



function colourSelector($classes){
    $presetcolours = array("#CFE8EF", "#E3256B", "#7D1D3F", "#D7D9B1", "#827191", "#F2D492");
    $colours=[];
    for($i=0;$i<count($classes);$i++){

        if(!empty($_POST) && isset($_SESSION["colour".$classes[$i]])) {
            unset($_SESSION["colour".$classes[$i]]);
        }

        if(isset($_POST["colour".$classes[$i]])){
            $_SESSION["colour".$classes[$i]]= $_POST["colour".$classes[$i]];
        }


        if(isset($_SESSION["colour".$classes[$i]])){
            
            $colours[$classes[$i]] = $_SESSION["colour".$classes[$i]];
        }else{
            $colours[$classes[$i]] =  $presetcolours[$i];
        }
        
    }
    return $colours;
}


function conflictRetrieval($times, $days){
    for ($d = 0; $d < count($days); $d++) {
        for ($t = 0; $t < count($times); $t++) {
            if(isset($_POST[$days[$d].$times[$t]])){
                $_SESSION[$days[$d].$times[$t]]=$_POST[$days[$d].$times[$t]];
            }

        }
    }

}

?>