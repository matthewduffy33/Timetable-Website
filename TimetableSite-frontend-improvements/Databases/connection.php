<?php
function DBConnection(){
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "timetable";

  // Create connection
  $conn = mysqli_connect($servername, $username, $password,$dbname);
  return $conn;

}
?>