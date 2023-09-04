
<?php
    function formCreator($colours, $pickedclasses, $default){

        $conn = DBConnection();

        $sql= "SELECT TypeID, ClassID, TypeOfSession FROM Type WHERE MultipleSessions=1 AND ClassID IN".printArray($pickedclasses);
        $classes = mysqli_query($conn, $sql);
        echo '<div class="hstack gap-3">';
        echo '<div>';
        while($row = mysqli_fetch_assoc($classes)) {
            echo "<br><br><label for='".$row['TypeID']."' >Choose a ". $row['TypeOfSession']." for ". $row["ClassID"].": </label>
            <select name='". $row["TypeID"] ."'>";
              additionalPicker( $row["ClassID"],$row["TypeOfSession"], $default); 
            echo "</select>";
        }
        echo '</div>';
        echo '<div>';
        classPicker($colours, $pickedclasses, $default);
        echo '</div></div>';

        if (str_contains($_SERVER['SCRIPT_NAME'], "timetable.php")) {
            echo "<br><br>";
            echo "<input type='submit' value='Submit'>";
            echo "<br><br>";
        }
    }

    function classPicker($colours, $pickedclasses, $default){
        $classes=array_keys($colours);
        foreach ($classes as $classID) { 
            if($default){
                echo"<input class='class".$classID."' type='checkbox' name='". $classID."' value=True checked>";
            }else{
                if(in_array($classID, $pickedclasses)){
                    echo "<input class='class".$classID."' type='checkbox' name='". $classID. "' value=True checked>";
                }else{
                    echo "<input class='class".$classID."' type='checkbox' name='". $classID."' value=True>";
                }
            }
            echo "<label class='class".$classID."' for='". $classID."'>" . $classID. "</label><br>";

            echo "<label class='class".$classID."' for='colorpicker'>Color Picker:</label>";
            echo "<input class='class".$classID."' type='color' name='colour".$classID."' value=".$colours[$classID]."  ><br>";
     

/*        broken code - fix for color picker element
     echo '<div class="d-flex align-items-center justify-content-center">
                <div class="color-picker-contain p-1" id="'.$classID.'-picker-contain" >
                    <center><label>';
                    if($default){
                        echo '<input type="checkbox" name="'. $classID.'" id='.$classID.' class="invisible" value=True checked>';
                    }else{
                        if(in_array($classID, $pickedclasses)){
                            echo '<input type="checkbox" name="'. $classID.'" id='.$classID.' class="invisible" value=True checked>';
                        }else{
                            echo '<input type="checkbox" name="'. $classID.'" id='.$classID.' class="invisible" value=True>';
                        }
                    }
                    echo '
                        <a class="display-5 color-picker-label" id="'.$classID.'-picker-label" onclick="updateColorPickerLabel('.$classID.')">'. $classID.'</a>
                    </label></center>
                    <br>
                    <input type="text" class="pickr" id="'.$classID.'-color-picker">
                </div>
            </div>
            '; */
    }
}


    function additionalPicker($classID, $type, $default){
        $conn = DBConnection();

        $sql= "SELECT SessionID, Type.TypeID, WhichDay, StartTime, EndTime  FROM Type, Sessions WHERE Type.TypeID=Sessions.TypeID AND ClassID ='$classID' AND TypeOfSession ='$type' AND MultipleSessions=1";
        $class = mysqli_query($conn, $sql);


        if ($default){
            while($row = mysqli_fetch_assoc($class)) {
                echo"<option class='class".$classID."' value='".$row["SessionID"]."' >". $row["WhichDay"] ." ". $row["StartTime"]. " " . $row["EndTime"]. "</option>";
            }
        }else{
            while($row = mysqli_fetch_assoc($class)) {
                if($row["SessionID"]== $_SESSION[$row["TypeID"]]){
                    echo "<option class='class".$classID."' selected value='".$row["SessionID"]."' >". $row["WhichDay"] ." ". $row["StartTime"]. " " . $row["EndTime"]." </option>";
                }else{
                    echo "<option class='class".$classID."' value='".$row["SessionID"]."' >".$row["WhichDay"] ." ". $row["StartTime"]. " " . $row["EndTime"]. " </option>";
                }
            }
        }
    }
?>
