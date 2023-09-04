<?php
include 'header.php';
include 'Databases/connection.php'; 
include 'PHPFunctions/formRetrieval.php'; 
include 'PHPFunctions/formCreation.php'; 
include 'PHPFunctions/indexForm.php'; 

session_start();
?>

<head>
  
</head>

<body>
<script src="modal.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>
<script src="colorpicker.js"></script>

<div>
  <form method="post" id="indexForm" action="<?php echo htmlspecialchars("timetable.php");?>">
      <?php indexForm() ?>
  </form>
</div>

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
    document.getElementById("nextBtn").classList.add("ms-auto");
  } else {
    document.getElementById("prevBtn").style.display = "inline";
    document.getElementById("nextBtn").classList.remove("ms-auto");
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "<span>Submit</span>";
  } else {
    document.getElementById("nextBtn").innerHTML = "<span>Next</span>";
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

  const d = new Date();
  d.setTime(d.getTime() + (50*24*60*60*1000));
  let expires = "expires="+ d.toUTCString();


  if(currentTab ==1){

    var cvalue = document.getElementById("course").value;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      document.getElementById("year").innerHTML =
        this.responseText 
    };

    xmlhttp.open("GET", "PHPFunctions/year.php?Course=" + cvalue, true);
    xmlhttp.send();

  }else if(currentTab ==2){
    var year = document.getElementById("year").value;
    var course = document.getElementById("course").value;
    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      document.getElementById("Setting").innerHTML =
      this.responseText;
    };

    xmlhttp.open("GET", "PHPFunctions/classes.php?Course=" + course+"&Year="+year, true);
    xmlhttp.send();
  }
  if (currentTab >= x.length) {
    //...the form gets submitted:
    document.getElementById("indexForm").submit();
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

</body>


<?php
include 'footer.php'
?>