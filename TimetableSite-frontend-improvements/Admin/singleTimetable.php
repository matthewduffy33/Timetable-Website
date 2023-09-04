<?php


   
    function timetableMaker($day, $time, $classID,$sessions){
        
        $conn = DBConnection();

        $sql= "SELECT SessionID, Room, TypeOfSession FROM Sessions, Type, Classes WHERE WhichDay= '$day' && StartTime= '$time' && EndTime> '$time' && Sessions.TypeID= Type.TypeID && Type.ClassID=Classes.ClassID && Classes.ClassID ='". $classID."' && SessionID NOT IN".printArray($sessions);
        $class = mysqli_query($conn, $sql);

        $sessions=multipleSessions($class,$sessions);

        $class = mysqli_fetch_assoc($class);
        if($class){
            echo "<td style='border-right: none;' class=lectureSlot onclick=\"formSubmiter('".$class["SessionID"]."', '".$class["TypeOfSession"]."', '". $class["Room"] ."', '".$day."', '".$time."', '". addHour($time, 1) ."', ". true.", '".$classID."')\" >" . $class["TypeOfSession"] ."<br>". $class["Room"] ." </td>";
            
            
            if($class["EndTime"]=addHour($time, 1)){
                $sessions[]=$class["SessionID"];
            }
            
            
        }else{
            $sql= "SELECT SessionID, Room, TypeOfSession, StartTime FROM Sessions, Type, Classes WHERE WhichDay= '$day' && StartTime< '$time' && EndTime> '$time' && Sessions.TypeID= Type.TypeID && Type.ClassID=Classes.ClassID && Classes.ClassID ='". $classID."' && SessionID NOT IN".printArray($sessions);
            $class = mysqli_query($conn, $sql);
            $sessions=multipleSessions($class,$sessions);

            $class = mysqli_fetch_assoc($class);
            
            if($class){
                echo "<td style='border-left: none;'class=lectureSlot onclick=\"formSubmiter('".$class["SessionID"]."', '".$class["TypeOfSession"]."', '". $class["Room"] ."', '".$day."', '".$time."', '". addHour($time, 1) ."',". true.", '".$classID."')\" > </td>";
                
                if($class["EndTime"]=addHour($time, 1)){
                    $sessions[]=$class["SessionID"];
                }
            }else{
                echo "<td style='border-right: none;'class=lectureSlot onclick=\"formSubmiter('', '', '', '".$day."', '".$time."', '".addHour($time, 1)."', false, '".$classID."')\"> </td> ";
            }
        }
        
        return $sessions;
        
        
    }

    function addHour($time, $hour){
        sscanf($time,"%d:%s",$hour,$minutes);
        return $hour+1 .":".$minutes;
    }


    function multipleSessions($classes,$sessions){
        if(($classes->num_rows)>1){
            $GLOBALS['multipleSessions'] =1;
            
        }
        return $sessions;
    }

    function printArray($array){
        $print= "(";
        if(count($array)>=1){
            for($i=0;$i<count($array)-1;$i++){
                $print= $print."'". $array[$i]."', ";
            }
            $print= $print."'". $array[$i]."'";
        }else{
            $print= $print."''";
        }
        
        $print= $print .")";
        return $print;
    }

    function allSessions($id){
        $conn = DBConnection();

        

        $sql= "SELECT TypeOfSession, WhichDay, StartTime, EndTime FROM Type,Sessions WHERE Type.TypeID=Sessions.TypeID && ClassID='".$id."'";

        $result = mysqli_query($conn, $sql);
        echo "<br> Other:<br>";
        while($row = mysqli_fetch_assoc($result)) {
            echo $row["TypeOfSession"].$row["WhichDay"]. $row["StartTime"].$row["EndTime"]."<br>";
        }
    }


    function lectureModals($id){

        ?>
        
        <div class='modal fade' id='lModal' tabindex='-1' aria-labelledby='lectureModalLabel' aria-hidden='true'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h1 class='modal-title fs-5' id='lectureModalLabel'>Session: </h1>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <form method="post" action="">
                        <div class='modal-body'>

                            <input type='hidden' name='id' id="currID" value="">

                            <input type='hidden' name='sessionID' id="sessionID" value="">

                            <label for="type">Type:</label>

                            <input type="text" name="type" id="type" value="" list="typeList">
                            <?php selectType($id);?><br>
                
                            Room: <input type="text" name="room" id="room" value=""><br>

                            Day: <input type="text" name="day" id="day" value=""><br>
                
                            Start Time: <input type="time" id="start" name="start" min="09:00" max="17:00" step="3600" required><br>

                            End Time: <input type="time" id="end" name="end" min="09:00" max="17:00" step="3600" required><br>
                    

                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                            <button type='submit' class='btn btn-primary' id='edit' name='edit' value='true'>Edit</button>
                            <button type='submit' class='btn btn-primary' id='add' name='add' value='true'>Add</button>
                            <button type='submit' class='btn btn-primary'  id='delete' name='delete' value='true'>Delete</button>
                            <button type='button' onclick="formSubmiter('', '', '', '', '', '', false, '')" class='btn btn-primary' data-bs-dismiss='modal'  id='new' name='new' value='true'>Add a New Session</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <?php


    }

    function selectType($id){
        $conn = DBConnection();

        $sql= "SELECT TypeID, TypeOfSession FROM Type WHERE ClassID='".$id."';";

        $result = mysqli_query($conn, $sql);

        echo "<datalist id='typeList'>";
        

        while($row = mysqli_fetch_assoc($result)) {
            echo "<option value='".$row["TypeOfSession"]."' >";
        }
        echo"</datalist>";

    
    }

    function editSession($id, $type, $room, $start, $end, $day){
        $conn = DBConnection();

        $sql= "UPDATE Sessions
                SET TypeID='".$type."', WhichDay='". $day."', StartTime='".$start."', EndTime='".$end."', Room='".$room."'
                WHERE SessionID='".$id."';";

        mysqli_query($conn, $sql);
    }


    function addSession($id, $type, $room, $start, $end, $day){
        $conn = DBConnection();

        $sql= "SELECT TypeID FROM Type WHERE TypeOfSession='".$type."'";
        $class = mysqli_query($conn, $sql);

        $class = mysqli_fetch_assoc($class);
        if($class){
            $type=$class["TypeID"];
        }else{
            $sql= "INSERT INTO Type
                VALUES('".$id.$type."', '". $id."', '".$type."', 0);";

            mysqli_query($conn, $sql);

            $sql= "SELECT TypeID FROM Type WHERE TypeOfSession='".$type."'";
            $class = mysqli_query($conn, $sql);

            $class = mysqli_fetch_assoc($class);
            $type=$class["TypeID"];
        }

        $sql= "INSERT INTO Sessions
                VALUES(NULL,'".$type."', '". $day."', '".$start."','".$end."', '".$room."');";

        mysqli_query($conn, $sql);

    }

    function deleteSession($id){
        $conn = DBConnection();

        $sql= "DELETE FROM SESSIONS WHERE SessionID='".$id."'";

        mysqli_query($conn, $sql);
    }

?>

<script>
    function formSubmiter(sessionID, type, room, day, start, end, edit, classID){
        
        
        var myModal = new bootstrap.Modal(document.getElementById('lModal'))
        myModal.show()

        
        document.getElementById("room").value = room;
        document.getElementById("day").value = day;
        document.getElementById("start").value = start;
        document.getElementById("end").value = end;
        document.getElementById("currID").value = classID;
        document.getElementById("sessionID").value = sessionID;
        document.getElementById("type").value = type;

        if(edit){
            document.getElementById("edit").style.display = "block";
            document.getElementById("add").style.display = "none";
            document.getElementById("delete").style.display = "block";
            document.getElementById("new").style.display = "block";
        }else{
            document.getElementById("edit").style.display = "none";
            document.getElementById("add").style.display = "block";
            document.getElementById("delete").style.display = "none";
            document.getElementById("new").style.display = "none";
        }
        
    }

</script>


    
