<?php

    function timetableFiller($day, $time, $colours, $allSessions, $count, $continuing, $timeCount){

        if(isset($_SESSION[$day.$time]) && $count==1){
            
            if($continuing == $_SESSION[$day.$time]){
                return slot($day, $time, $colours, $allSessions, $_SESSION[$day.$time], 1);
            }else{
                return slot($day, $time, $colours, $allSessions, $_SESSION[$day.$time], 0);
            }
            
        }else if(isset($allSessions[$day.$time]) && !isset($_SESSION[$day.$time])){

            if(!is_null($continuing)){
                return slot($day, $time, $colours, $allSessions, $continuing, 1);


            }else{
                $count= $count-$timeCount;
                $keys = array_keys($allSessions[$day.$time]);
                foreach($keys as $key){
                    if($allSessions[$day.$time][$key]["continuing"]==0){
                        $count--;
                    }

                    if($count==0){
                        return slot($day, $time, $colours, $allSessions, $key, 0);
                    }
                
                }

            }

        }
            
        echo "<td style='border-right: none;'> </td> ";
        return;
    }

    function slot($day, $time, $colours, $allSessions, $id, $continuing){
        if($continuing){
            echo "<td style='border-left: none; background-color:". $colours[$allSessions[$day.$time][$id]["ClassID"]].";' onclick=\"hideSlot('".$day.$time."', '".$id."')\"> </td>";
        
        }else{
            echo "<td style='border-right: none; background-color:".$colours[$allSessions[$day.$time][$id]["ClassID"]]. ";' onclick=\"hideSlot('".$day.$time."', '".$id."')\">" . $allSessions[$day.$time][$id]["ClassID"] ."<br>". $allSessions[$day.$time][$id]["TypeOfSession"]."<br>". $allSessions[$day.$time][$id]["ClassName"]."<br>". $allSessions[$day.$time][$id]["Room"] ." </td>";
      
        }
                        
        if(!str_contains($allSessions[$day.$time][$id]["End"], addHour($time))){
            return $allSessions[$day.$time][$id]["SessionID"];
        }

    }

    function dbRetriever($days, $times, $elective, $pickedclasses, $additional){

        $conn = DBConnection();

        $sql= "SELECT Classes.ClassID, SessionID, ClassName, Room, TypeOfSession, WhichDay, TIME_FORMAT(StartTime, '%H:%i') as Start, TIME_FORMAT(EndTime, '%H:%i') as End  FROM Type, Sessions, Classes WHERE Type.ClassID=Classes.ClassID  && Sessions.TypeID = Type.TypeID && Classes.ClassID in ".printArray($pickedclasses)." && (MultipleSessions = 0 OR SessionID in". printArray($additional).")";
        $result = mysqli_query($conn, $sql);

        $allSessions=array();

        while($row = mysqli_fetch_array($result)){
            $span =timespan($row["Start"], $row["End"]);
            

            foreach($span as $time){
                if(isset($_COOKIE[$row["WhichDay"].$row["Start"]."hidden"])){
                    $hidden=json_decode($_COOKIE[$row["WhichDay"].$row["Start"]."hidden"]);
                }else{
                    $hidden=array();
                }

                if(!in_array($row["SessionID"], $hidden)){
                    if(str_contains($row["Start"], $time)){
                        $row["continuing"]=0;
                    }else{
                        $row["continuing"]=1;
                    }
                    $allSessions[$row["WhichDay"].$time][$row["SessionID"]]=$row;
    

                }
                
            }

            
        }

        
        if(in_array($elective, $pickedclasses)){
            for($d = 0; $d < count($days); $d++){
                for($t = 0; $t < count($times); $t++){

                    $start=electiveStartTime($elective, $days[$d], $times[$t]);
                    $end=electiveEndTime($elective, $days[$d], $times[$t]);

                    if(isset($_COOKIE[$start.$end."hidden"])){
                        $hidden=json_decode($_COOKIE[$start.$end."hidden"]);
                    }else{
                        $hidden=array();
                    }
    
                    if(!in_array($_COOKIE["electiveID"], $hidden)){

                        if(isset($_COOKIE[$elective.$days[$d].$times[$t]."type"])){
                            $elec=array();
                            $elec["ClassID"]=$_COOKIE["electiveID"];
                            $elec["SessionID"]=$_COOKIE["electiveID"];
                            $elec["ClassName"]=$_COOKIE["electiveName"];
                            $elec["Room"]=$_COOKIE[$elective.$days[$d].$times[$t]."room"];
                            $elec["TypeOfSession"]=$_COOKIE[$elective.$days[$d].$times[$t]."type"];
                            $elec["WhichDay"]=$days[$d];
                            $elec["Start"]=$start;
                            $elec["End"]=$end;
                            if(isset($_COOKIE[$elective.$days[$d].addHour($times[$t])."continuing"])){
                                $elec["continuing"]=1;
                            }else{
                                $elec["continuing"]=0;
                            }
                            
                            $allSessions[$days[$d].$times[$t]][$elec["SessionID"]]=$elec;
                        }
                    }
    
                }
    
            }

        }
        

        /*for($d = 0; $d < count($days); $d++){
            for($t = 0; $t < count($times); $t++){
                if(isset($allSessions[$days[$d].$times[$t]])){
                    $keys = array_keys($allSessions[$days[$d].$times[$t]]);
                    foreach($keys as $key){
                        echo $allSessions[$days[$d].$times[$t]][$key]["SessionID"]."<br>";

                    }

                }
            }
        }*/

        return $allSessions;

    }

    function maxConflicts($day, $times, $allSessions){
        $max=1;
        foreach($times as $time){
            if(isset($allSessions[$day.$time]) && !isset($_COOKIE[$day.$time]) && sizeof($allSessions[$day.$time])>$max){
                $max=sizeof($allSessions[$day.$time]);
            }
        }
        return $max;

    }

    function timespan($start, $end){
        $span=array($start);

        while(!str_contains($end, addHour($start))){
            $start= addHour($start);
            $span[]=$start;
        }

        return $span;
    }

    function electiveEndTime($elective, $day, $time){
        while(isset($_COOKIE[$elective.$day.addHour($time)."continuing"])){
            $time=addHour($time);
        }
        return addHour($time);
    }

    function electiveStartTime($elective, $day, $time){
        if(isset($_COOKIE[$elective.$day.$time."continuing"])){
            while(isset($_COOKIE[$elective.$day.removeHour($time)."continuing"])){
                $time=removeHour($time);
            }
            return removeHour($time);

        }else{
            return $time;
        }
        
    }

    function addHour($time){
        sscanf($time,"%d:%s",$hour,$minutes);
        return $hour+1 .":".$minutes;
    }

    function removeHour($time){
        sscanf($time,"%d:%s",$hour,$minutes);
        return $hour-1 .":".$minutes;
    }


    

    function conflictFinder($pickedclasses, $additional){
        $conn = DBConnection();
        $sql= "SELECT WhichDay, StartTime, EndTime, COUNT(SessionID)  
        FROM Sessions S1, Sessions S2
        WHERE S1.WhichDay= S2.WhichDay && S1.StartTime>=S2.StartTime && S1.EndTime>=S2.EndTime && Classes.ClassID in ".printArray($pickedclasses)." && (MultipleSessions = 0 OR SessionID in". printArray($additional).")";
        mysqli_query($conn, $sql);
    }


    function printArray($array){
        $print= "(";
        if($array){
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


    function electiveForm(){
        if(!isset($_COOKIE["electiveID"])){
            ?>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#electiveCreationModal">
                    Add Elective
                </button>

                <!-- Modal -->
                <div class="modal fade" id="electiveCreationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" action="elective.php">
                            <div class='modal-body'>
                                    
                            Class ID: <input type="text" name="electiveID" value=""><br>
                            Class Name: <input type="text" name="electiveName" value=""><br>          

                            </div>

                            <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                            <button type='submit' class='btn btn-primary' id='add' name='add' value='true'>Add</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            <?php
        }else{
            ?>
                <form method="post" action="elective.php">

                    <input type='hidden' name='id' id="currID" value= <?php echo $_COOKIE["electiveID"] ?> >

                    <button type='submit' class='btn btn-primary' id='edit' name='Edit Elective' value='true'>Edit Elective</button>

                </form>


                <?php echo"<button type=\"button\" onclick=\"deleteElective('".$_COOKIE["electiveID"]."')\">Delete Elective</button>";

            
        }
    }


    function totalCon($days, $times, $allSessions){
        $total=0;
        foreach($days as $day){
            foreach($times as $time){
                if(isset($allSessions[$day.$time])&& sizeof($allSessions[$day.$time])>1){
                    $total++;
                }
            }
        }
        return $total;

    }

    function locationsCon($days, $times, $allSessions){
        $locations =array();
        foreach($days as $day){
            foreach($times as $time){
                if(isset($allSessions[$day.$time])&& sizeof($allSessions[$day.$time])>1){
                    $locations[] = $day.$time;
                }
            }
        }
        return $locations;

    }

    function conflictModal($total, $conflictLocations, $allSessions){
        ?>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#electiveCreationModal">
                    Solve Conflicts
                </button>

                <!-- Modal -->
                <div class="modal fade" id="electiveCreationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Conflicts</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                <div class="modal-body">

                                    <div id="carouselExample" class="carousel slide">
                                        <div class="carousel-inner">
                                            
                                            <?php for($i=0; $i<$total; $i++){
                                                if($i==0){?>
                                                    <div class="carousel-item active">
                                                        <?php conflictForm($conflictLocations[$i], $allSessions)?>
                                                    </div><?php
                                                }else{?>
                                                    <div class="carousel-item">
                                                        <?php conflictForm($conflictLocations[$i], $allSessions)?>
                                                    </div><?php

                                                }

                                            }?>
                                            

                                        </div>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    </div>

                                </div>

                                <div class='modal-footer'>
                                    <button type='submit'  class='btn btn-primary' >Solve Conflicts</button>
                                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            <?php

    }

    function conflictForm($conflict, $allSessions){
        echo"
                <div class='modal-body'>
                    ". $conflict."<br><br>";
                    for($i=0;$i<sizeof($allSessions[$conflict]);$i++){

                        $keys = array_keys($allSessions[$conflict]);
                        $con=$allSessions[$conflict][$keys[$i]];

                        if(isset($_COOKIE[$conflict]) && $_COOKIE[$conflict] == $con["SessionID"]){
                            echo "<input type=\"radio\" id=\"".$conflict.$i."\" name=\"".$conflict."\" value=\"".$con["SessionID"]."\" checked>";
                        }else{
                            echo "<input type=\"radio\" id=\"".$conflict.$i."\" name=\"".$conflict."\" value=\"".$con["SessionID"]."\">";
                        }
                        echo "<label for=\"".$conflict."\">".$con["ClassID"]." ".$con["TypeOfSession"]." ".$con["Room"]." ".$con["Start"]." ".$con["End"]."</label><br>";
                    }                        

                echo"</div>";
    }


    function showAll($days, $times){
        $hiddenBool = False;
        foreach($days as $day){
            foreach($times as $time){
                if(isset($_COOKIE[$day.$time."hidden"])){
                    $hiddenBool = True;
                }
            }
        }

        if($hiddenBool){
            echo "<button type=\"button\" onclick=\"showSessions()\">Show All Sessions</button>";
        }

    }
?>

<script>
    function formHandler(index, conflict){
        
  
        for(i=0; i<index; i++){
            if(document.getElementById(conflict+i).checked){
                
                const d = new Date();
                d.setTime(d.getTime() + (50*24*60*60*1000));
                let expires = "expires="+ d.toUTCString();
                document.cookie = conflict + "=" + document.getElementById(conflict+i).value + ";" + expires + ";path=/";
                
            }
        }
    }

    function showSessions(){
        const days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];
        const times = ["09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00"];
        
  
        for (let d = 0; d < days.length; d++) {
            for (let t = 0; t < times.length; t++) {
                document.cookie = days[d]+times[t]+"hidden=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            }

        }
        location.reload();        
                
        
    }

    function deleteElective(elective){
        const days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];
        const times = ["09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00"];
        
  
        for (let d = 0; d < days.length; d++) {
            for (let t = 0; t < times.length; t++) {
                document.write(elective+days[d]+times[t]+"type");
                document.cookie = elective+days[d]+times[t]+"type=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                document.cookie = elective+days[d]+times[t]+"room=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                document.cookie = elective+days[d]+times[t]+"continuing=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            }

        }
        
        document.cookie = "electiveID=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        document.cookie = "electiveName=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        document.cookie = elective + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        location.reload();        
                
        
    }

    function hideSlot(slot, id){

        const d = new Date();
        d.setTime(d.getTime() + (50*24*60*60*1000));
        let expires = "expires="+ d.toUTCString();
        
        var hiddenSlot = [];
        
        let hidden =getCookie(slot+"hidden");
        
        
        if (hidden != "") {
            
            hiddenSlot = JSON.parse(hidden);
            document.write(hiddenSlot[0]);
        }
        
        hiddenSlot[hiddenSlot.length]=id;

        

        document.cookie = slot +  "hidden=" + JSON.stringify(hiddenSlot) + ";" + expires + ";path=/";

        location.reload(); 

    }

    function getCookie(cname) {
        
        let name = cname + "=";
        
        let decodedCookie = decodeURIComponent(document.cookie);
        
        let ca = decodedCookie.split(';');
        for(let i = 0; i <ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
            c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
            }
        }
        return "";
    }

</script>