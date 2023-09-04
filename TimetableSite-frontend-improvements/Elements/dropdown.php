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
<div class="h-100 vstack align-items-center justify-content-center">
    <div class="display-4">
      <label for="cars"><span class="select-lbl">i am</span></label>
      <select name="cars" id="cars">
        <option value="volvo">Volvo</option>
        <option value="saab">Saab</option>
        <option value="mercedes">Mercedes</option>
        <option value="audi">Audi</option>
      </select>
</span>
    </div>
    <br><br>

    <div class="hstack gap-5">
    <div class>
      <br>
      <span class="step finish"></span>
      <span class="step active"></span>
      <span class="step"></span>
    </div>

    <button type="button" class="form-btn btn btn-lg ms-auto"><span>Large button</span></button>
    <button type="button" class="form-btn btn btn-lg"><span>Large button</span></button>
</div>
</div>


</body>