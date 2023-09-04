<?php
include 'header.php';
include 'Databases/connection.php'; 
include 'PHPFunctions/formRetrieval.php'; 
include 'PHPFunctions/formCreation.php'; 
include 'PHPFunctions/timetableCreation.php'; 

$times = array("09:00","10:00","11:00","12:00","13:00","14:00","15:00","16:00"); 
$days = array ("Monday","Tuesday","Wednesday","Thursday","Friday");

$additional= arrayOfAdditional();

if(isset($_POST["year"])){
    $_SESSION["year"]= $_POST["year"];
    $_SESSION["course"]= $_POST["course"];
}

$classes = arrayOfClasses();

$elective="";

if(isset($_COOKIE["electiveID"])){
    $classes[]=$_COOKIE["electiveID"];
    $elective=$_COOKIE["electiveID"];
}


$pickedclasses = arrayOfPickedClasses($classes);

$colours = colourSelector($classes);


conflictRetrieval($times, $days);

$allSessions=dbRetriever($days, $times, $elective, $pickedclasses, $additional);

$maxDays=array();

foreach($days as $day){
    $maxDays[]=maxConflicts($day, $times, $allSessions);
}


?>


<head>
  
</head>

<body>
<script src="modal.js"></script>
    <div>
        <table class='table table-bordered'>
            <thead>
                <tr>
                    <th scope='col'></th>
                    <?php for ($i = 0; $i < count($times); $i++) {
                        echo "<th scope='col'>".$times[$i]."</th>";
                    }?>

                </tr>
            </thead>

            <tbody>

            <?php


            for ($d = 0; $d < count($days); $d++) {
                $continuing=null;
                $timeCount=array(0, 0, 0, 0, 0, 0, 0, 0);
                $count=0;

                do{

                    echo"<tr>";
                    if($count==0){
                        echo"<th scope='row'>".$days[$d]."</th>";
                    }else{
                        echo"<th scope='row'></th>";
                    }
                    
                    for ($t = 0; $t < count($times); $t++) {
                        
                        if(!is_null($continuing)){
                            $timeCount[$t]++;
                        }

                        $continuing=timetableFiller($days[$d], $times[$t], $colours, $allSessions, $count+1, $continuing, $timeCount[$t]);
                    }
                      
                    echo"</tr>";  
                    $count++;                 
                }while($count<$maxDays[$d]);
            }?>
                               
            </tbody>
        </table>
    </div>



<div>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <?php formCreator($colours, $pickedclasses, 0) ?>
  </form>
</div>


<?php electiveForm();

$totalConflicts = totalCon($days, $times, $allSessions);
$conflictLocations = locationsCon($days, $times, $allSessions);

if($totalConflicts>0){
    conflictModal($totalConflicts, $conflictLocations, $allSessions);

}


showAll($days, $times);


?>
</body>


<?php
include 'footer.php'
?>