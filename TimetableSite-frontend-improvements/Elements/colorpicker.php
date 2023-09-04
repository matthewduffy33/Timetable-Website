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
<div class="h-100 d-flex align-items-center justify-content-center mx-5 p-2">
    <div class="color-picker-contain p-2" id="class-picker-contain" >
        <center><label>
            <input type="checkbox" name="class" id="class" class="invisible" checked>
            <a class="display-5 color-picker-label" id="class-picker-label" onclick="updateColorPickerLabel()">hi</a>
        </label></center>
        <br>
        <input type="text" class="pickr" id="class-color-picker">
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>
<script src="colorpicker.js"></script>

</body>