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
<div class="h-100 align-items-center justify-content-center mx-5 p-4">
<table class="table table-responsive">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">09:00</th>
                    <th scope="col">10:00</th>
                    <th scope="col">11:00</th>
                    <th scope="col">12:00</th>
                    <th scope="col">13:00</th>
                    <th scope="col">14:00</th>
                    <th scope="col">15:00</th>
                    <th scope="col">16:00</th>
                </tr>
            </thead>

            <tbody>
            <tr><th scope="row">Monday</th>
            <td style="background-color:#FF0000">
            <div class="class-slot">
                <span class="class-title py-1">CS210</span>
                <div class="class-content">
                Lecture
                <br>
                Computer systems and architecture
                <br>
                LT1105
                </div>
            </div>
            </td> 
            <td>
            <div class="empty-slot">
            </div>
            </td> 
            <td>
            <div class="hstack gap-4">
                CS210 
                <div class="vstack gap-3">
                Lecture
                <br>
                Computer systems and architecture
                <br>
                LT1105
                </div>
            </div>
            </td> 
            <td>
            <div class="hstack gap-4">
                CS210 
                <div class="vstack gap-3">
                Lecture
                <br>
                Computer systems and architecture
                <br>
                LT1105
                </div>
            </div>
            </td> 
            <td>
            <div class="hstack gap-4">
                CS210 
                <div class="vstack gap-3">
                Lecture
                <br>
                Computer systems and architecture
                <br>
                LT1105
                </div>
            </div>
            </td> 
            <td>
            <div class="hstack gap-4">
                CS210 
                <div class="vstack gap-3">
                Lecture
                <br>
                Computer systems and architecture
                <br>
                LT1105
                </div>
            </div>
            </td> 
            <td>
            <div class="hstack gap-4">
                CS210 
                <div class="vstack gap-3">
                Lecture
                <br>
                Computer systems and architecture
                <br>
                LT1105
                </div>
            </div>
            </td> 
            <td>
            <div class="hstack gap-4">
                CS210 
                <div class="vstack gap-3">
                Lecture
                <br>
                Computer systems and architecture
                <br>
                LT1105
                </div>
            </div>
            </td> 
        
        </tr>
            <tr><th scope="row">Tuesday</th><td > </td> <td > </td> <td > </td> <td > </td> <td > </td> <td > </td> <td > </td> <td > </td> </tr>
            <tr><th scope="row">Wednesday</th><td > </td> <td > </td> <td > </td> <td > </td> <td > </td> <td > </td> <td > </td> <td > </td> </tr>
            <tr><th scope="row">Thursday</th><td > </td> <td > </td> <td> </td> <td > </td> <td > </td> <td > </td> <td > </td> <td > </td> </tr>
            <tr><th scope="row">Friday</th><td >hi </td> <td > </td> <td > </td> <td > </td> <td > </td> <td > </td> <td > </td> <td >hi </td> </tr>                               
            </tbody>
        </table>
<div>
<button type="button" class="form-btn btn"><span>Large button</span></button>
</div>
    </div>


</body>