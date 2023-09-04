<?php
include 'Databases/connection.php';
include 'PHPFunctions/electiveCreation.php'; 

session_start();

$time = array("09:00","10:00","11:00","12:00","13:00","14:00","15:00","16:00"); 
$day = array ("Monday","Tuesday","Wednesday","Thursday","Friday");

if (isset($_POST["electiveID"])){
    setcookie("electiveID", $_POST["electiveID"], time() + (86400 * 365), "/");
    setcookie("electiveName", $_POST["electiveName"], time() + (86400 * 365), "/");
    setcookie("electiveTrue", True, time() + (86400 * 365), "/");

    $id= $_POST["electiveID"];
}else{
    $id= $_COOKIE["electiveID"];
}

$colour[$id]="Grey";





allSessions($id, $time, $day);
echo "<input type = 'button' onclick = \"clearSessions('".$id."')\" value = 'Clear'>";
?>



<head>

<link rel="stylesheet" href="style.css?v=<?php echo time(); ?>" type="text/css" >
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

</head>

<body>

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eModal">
  Launch demo modal
</button>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
 

<?php
        formHandler($id);
        lectureModals($id);
?>

    <div>
        <table class='table table-bordered'>
            <thead>
                <tr>
                    <th scope='col'></th>
                    <?php for ($i = 0; $i < count($time); $i++) {
                        echo "<th scope='col'>".$time[$i]."</th>";
                    }?>

                </tr>
            </thead>

            <tbody>

            <?php
            
                
                for ($d = 0; $d < count($day); $d++) {
                    echo"<tr>";
                    echo"<th scope='row'>".$day[$d]."</th>";
                    
                    
                    
                    for ($i = 0; $i < count($time); $i++) {
                        timetableMaker($day[$d], $time[$i], $id);
                    }   
                    echo"</tr>";
                                        
                  
                }
                ?>
                               
            </tbody>
        </table>
    </div>




</body>


<script>
    function cookieStorage(sessionNumber, sessionType, sessionDay sessionStart, sessionEnd, sessionRoom){
        const d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        let expires = "expires="+ d.toUTCString();
        document.cookie = "type" + sessionNumber + "=" + sessionType + ";" + expires + ";path=/";
        document.cookie = "day" + sessionNumber + "=" + sessionDay + ";" + expires + ";path=/";
        document.cookie = "start" + sessionNumber + "=" + sessionStart + ";" + expires + ";path=/";
        document.cookie = "end" + sessionNumber + "=" + sessionEnd + ";" + expires + ";path=/";
        document.cookie = "room" + sessionNumber + "=" + sessionRoom + ";" + expires + ";path=/";
    }
</script>