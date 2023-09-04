<?php
include 'admin.php';
include '../header.php';

$conn = DBConnection();


if(isset($_POST["edit"])){
    if(isset($_POST["CourseName"])){

    }else if(isset($_POST["year"])){
        $sql= "UPDATE Courses SET AmountOfYears='".$_POST["year"]."' WHERE CourseName='".$_POST["originalName"]."'";
        mysqli_query($conn, $sql);
    }else{
        $sql= "UPDATE Courses SET PlacementYear='".$_POST["placement"]."' WHERE CourseName='".$_POST["originalName"]."'";
        mysqli_query($conn, $sql);
    }
}else if(isset($_POST["remove"])){
    $sql= "UPDATE Courses SET PlacementYear= NULL WHERE CourseName='".$_POST["originalName"]."'";
    mysqli_query($conn, $sql);
}else if(isset($_POST["add"])){
    $sql= "INSERT INTO COURSES VALUES('".$_POST["CourseName"]."','".$_POST["year"]."','".$_POST["placement"]."')";
    mysqli_query($conn, $sql);
}

?>



<head>
  
</head>

<body>
<script src="modal.js"></script>

<div class="container">
    <?php allCourses(); ?>  
</div>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
  Add Course
</button>

<!-- Modal -->
<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Course</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form method="post" id="addForm" action="">
            <input type='hidden' name='add' value='True'/>

            <div class="tab">
                Course Name: <input type=\"text\" name='CourseName' value='' /><br>
                Amount of Years: <input type='number' id='year' name='year' min='1' max='10'>
            </div>

            <div class="tab" id="Placement" style="display:none;">

            </div>


            <div style="overflow:auto;">
                <div style="float:right;">
                    <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                    <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                </div>
            </div>

            <!-- Circles which indicates the steps of the form: -->
            <div style="text-align:center;margin-top:40px;">
                <span class="step"></span>
                <span class="step"></span>
            </div>

        </form>

      </div>
    </div>
  </div>
</div>

</body>


<script>
var currentTab = 0;

showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form ...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  // ... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  // ... and run a function that displays the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form... :



  if(currentTab ==1){
    var cvalue = document.getElementById("year").value;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        document.getElementById("Placement").innerHTML =
        this.responseText;
    };

    xmlhttp.open("GET", "addCourses.php?years=" + cvalue, true);
    xmlhttp.send();
    

  }

  if (currentTab >= x.length) {
    //...the form gets submitted:
    document.getElementById("addForm").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false:
      valid = false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class to the current step:
  x[n].className += " active";
}

</script>
