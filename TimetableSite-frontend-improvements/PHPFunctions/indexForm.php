<?php
function indexForm(){
    ?>

<div class="h-100 vstack align-items-center justify-content-center mx-5 p-5 gap-2">

    <div class="tab">
        <div class="display-5">
            <label><span class="select-lbl">course:</span></label>
            <?php courseSelector() ?>
            </span>
        </div>
    </div>

    <div class="tab" id="Yearcon">
        <div class="display-5">
        <label><span class="select-lbl">year:</span></label>
            <select id="year" name="year"></select>
            </span>
        </div>
    </div>


    <div class="tab" id="Setting">Setting:
    </div>

    <br><br>

    <div class="hstack gap-5">
        <div>
            <br>
            <span class="step"></span>
            <span class="step"></span>
            <span class="step"></span>
        </div>

        <button type="button" class="form-btn btn btn-lg ms-auto" id="prevBtn" onclick="nextPrev(-1)"><span>Previous</span></button>
        <button type="button" class="form-btn btn btn-lg" id="nextBtn" onclick="nextPrev(1)"><span>Next</span></button>
    </div>
</div>

    <?php
}

function courseSelector(){
    $conn = DBConnection();

    $sql= "SELECT CourseName  FROM Courses";
    $class = mysqli_query($conn, $sql);

    echo "<select id='course' name='course'>";
        while($row = mysqli_fetch_assoc($class)) {
            echo "<option value='".$row["CourseName"]."' >". $row["CourseName"] ." </option>";
        
        }
    echo "</select>";

}

/*function yearSelector(){

    $course= $_POST["CourseName"];
    echo $course;

    $conn = DBConnection();

    $sql= "SELECT Year FROM CourseYears WHERE CourseName='".$course."'";
    $class = mysqli_query($conn, $sql);

    echo "<select id='year' name='year'>";
        while($row = mysqli_fetch_assoc($class)) {
            echo "<option value='".$row["Year"]."' >". $row["Year"] ." </option>";
        
        }
    echo "</select>";


}*/

?>

