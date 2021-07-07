<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "root";
$dbname = "blog";


$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (mysqli_connect_error()) {
  // עוצר את הקובץ וכותב את ההודעה
  die("cant connect");
}

// דואג שמידע שיוצא ונכנס שהוא לא לטיני שיקודד נכון
// כגון עברית , ערבית
$conn->query("SET NAMES 'utf8'");
