<?php


   
    function timetableMaker($day, $time, $classID){
        
       

        if(isset($_COOKIE[$classID.$day.$time."type"])&& !isset($_COOKIE[$classID.$day.$time."continuing"])){
            echo "<td style='border-right: none;' class=lectureSlot onclick=\"formSubmiter('".$_COOKIE[$classID.$day.$time."type"]."', '". $_COOKIE[$classID.$day.$time."room"] ."', '".$day."', '".$time."', '". findingEnd($classID, $day, $time) ."', ". true.", '".$classID."')\" >" . $_COOKIE[$classID.$day.$time."type"] ."<br>". $_COOKIE[$classID.$day.$time."room"] ." </td>";
            
            
        }else{

            if(isset($_COOKIE[$classID.$day.$time."continuing"])){
                echo "<td style='border-right: none; border-left: none;'class=lectureSlot onclick=\"formSubmiter( '".$_COOKIE[$classID.$day.$time."type"]."', '". $_COOKIE[$classID.$day.$time."room"] ."', '".$day."', '".findingStart($classID, $day, $time)."', '". findingEnd($classID, $day, $time) ."',". true.", '".$classID."')\" > </td>";
                
            }else{
                echo "<td style='border-right: none;'class=lectureSlot onclick=\"formSubmiter('', '', '".$day."', '".$time."', '".addHour($time, 1)."', false, '".$classID."')\"> </td> ";
            }
        }
        
        
        
    }

    function addHour($time, $hour){
        sscanf($time,"%d:%s",$hour,$minutes);
        return $hour+1 .":".$minutes;
    }

    function removeHour($time, $hour){
        sscanf($time,"%d:%s",$hour,$minutes);
        return $hour-1 .":".$minutes;
    }

    function findingEnd($id, $day, $time){
        $end= addHour($time, 1);
        while(isset($_COOKIE[$id.$day.$end."continuing"])){
            $end= addHour($end, 1);
        }
        return $end;
    }

    function findingStart($id, $day, $time){
        $start= removeHour($time, -1);
        while(isset($_COOKIE[$id.$day.$start."continuing"])){
            $start= removeHour($start, -1);
        }
        return $start;
    }


    function allSessions($id,$times, $days){
        echo "<br> Sessions:<br>";
        for($d=0; $d<sizeof($days); $d++){
            for($t=0; $t<sizeof($times); $t++){
                if(isset($_COOKIE[$id.$days[$d].$times[$t]."type"])){
                    echo $_COOKIE[$id.$days[$d].$times[$t]."type"].", ". $_COOKIE[$id.$days[$d].$times[$t]."room"]."<br>";
                }
                
            }
       }

    }

    


    function lectureModals($id){

        ?>
        
        <div class='modal fade' id='eModal' tabindex='-1' aria-labelledby='lectureModalLabel' aria-hidden='true'>
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

    


    function addSession($id, $type, $room, $start, $end, $day){
        $num=1;
        $time=$start;
        while($time<$end){
            setcookie($id.$day.$time."type", $type, time() + (86400 * 365), "/");
            setcookie($id.$day.$time."room", $room, time() + (86400 * 365), "/");
            if ($num>1){
                setcookie($id.$day.$time."continuing", 1, time() + (86400 * 365), "/");
            }
            $num++;
            $time=addHour($time,1);
        }
        

    }

   


    function deleteSession($id, $time, $day){
        do{
            setcookie($id.$day.$time."type", "", time() - 3600, "/");
            setcookie($id.$day.$time."room", "", time() - 3600, "/");
            setcookie($id.$day.$time."continuing", "", time() - 3600, "/");
            $time=addHour($time,1);
        }while(isset($_COOKIE[$id.$day.$time."continuing"]));
        
    }

    function formHandler($id){
        if(isset($_POST["type"])){
            if(isset($_POST["delete"])){
                deleteSession($id, $_POST["start"], $_POST["day"]);
            }else{
                addSession($id, $_POST["type"], $_POST["room"], $_POST["start"], $_POST["end"], $_POST["day"]);
            }
            Header('Location: '.$_SERVER['PHP_SELF']);

        }

    }

    
    

    

?>

<script>
    function formSubmiter(type, room, day, start, end, edit, classID){
        
       
        var modal = new bootstrap.Modal(document.getElementById('eModal'))
        modal.show()

        
        document.getElementById("room").value = room;
        document.getElementById("day").value = day;
        document.getElementById("start").value = start;
        document.getElementById("end").value = end;
        document.getElementById("currID").value = classID;
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

    function clearSessions(id){
        var allcookies = document.cookie;
        cookiearray = allcookies.split(';');   
        
        for(let i=0; i<cookiearray.length; i++) {
            name = cookiearray[i].split('=')[0];
            value = cookiearray[i].split('=')[1];

            if(name.includes(id)){
                document.cookie= (name+"=; expires= Thu, 01 Jan 1970 00:00:00 UTC; path=/;");
           }
            
            
       }
       location.reload();

    }


    

</script>

