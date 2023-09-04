<?php
include 'admin.php';
include 'singleTimetable.php';  

$time = array("09:00","10:00","11:00","12:00","13:00","14:00","15:00","16:00"); 
$day = array ("Monday","Tuesday","Wednesday","Thursday","Friday");

$id= $_POST["id"];
$colour[$id]="Grey";


if(isset($_POST["type"])){
    if(isset($_POST["edit"])){
        editSession($_POST["sessionID"], $_POST["type"], $_POST["room"], $_POST["start"], $_POST["end"], $_POST["day"]);
    }else if(isset($_POST["add"])){
        addSession($id, $_POST["type"], $_POST["room"], $_POST["start"], $_POST["end"], $_POST["day"]);
    }else{
        deleteSession($_POST["sessionID"]);
    }

}
?>



<head>
<link rel="stylesheet" href="../style.css?v=<?php echo time(); ?>" type="text/css" >
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">


</head>

<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
 

<?php
        allSessions($id);
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

            <?php for ($d = 0; $d < count($day); $d++) {
                $multipleSessions=0;
                $sessions=array();
                do{
                    echo"<tr>";
                    if($multipleSessions==0){
                        echo"<th scope='row'>".$day[$d]."</th>";
                    }else{
                        echo"<th scope='row'></th>";
                    }
                    $multipleSessions=0;
                    

                    
                    
                    for ($i = 0; $i < count($time); $i++) {
                        $sessions=timetableMaker($day[$d], $time[$i], $id, $sessions);
                    }   
                    echo"</tr>";
                                        
                }while($multipleSessions==1);
              }?>
                               
            </tbody>
        </table>
    </div>




</body>
